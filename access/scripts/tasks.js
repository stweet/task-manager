
let ETaskFilter = function( ) {
    let panel = $("#task-filter");

    let state = new ESelect("Состояние");
        state.setList(BJTaskFilter.states);
        state.addClass("filter-states");
        state.appendTo(panel);
        
    let order = new ESelect("Сортировка");
        order.setList(BJTaskFilter.orders);
        order.addClass("filter-orders");
        order.appendTo(panel);
        
    let limit = new ESelect("Лимит");
        limit.setList(BJTaskFilter.limits);
        limit.addClass("filter-limits");
        limit.appendTo(panel);

    state.on("select", function(event, data) {
        BJTaskFilter.changeState(data);
    });
    
    order.on("select", function(event, data) {
        BJTaskFilter.changeOrder(data);
    });
    
    limit.on("select", function(event, data) {
        BJTaskFilter.changeLimit(data);
    });
    
    BJApplication.addListener("filter.update", function(event) {
        state.setTitle(event.target.state.label);
        order.setTitle(event.target.order.label);
        limit.setTitle(event.target.limit.label);
    });

    return panel;
};

let ETaskEditForm = function() {
    let values = {};

    let container = $("<div>");

    let navi = $("<div>");
        navi.appendTo(container);
        navi.css("margin-bottom", "30px");
    
    let editor = $("<a>", {"href": "javascript:void(0)", "class": "btn btn-default disabled"});
        editor.text("Редактор");
        editor.appendTo(navi);
    
    let preview = $("<a>", {"href": "javascript:void(0)", "class": "btn btn-default pull-right"});
        preview.text("Предосмотр");
        preview.appendTo(navi);

    let form = $("<div>", {"class": "row"});
        form.appendTo(container);

    let view = $("<div>");
        view.appendTo(container);
        view.text("preview");
        view.hide();
    
    let lCol = $("<div>", {"class": "col-xs-6"});
        lCol.appendTo(form);
    
    let rCol = $("<div>", {"class": "col-xs-6"});
        rCol.appendTo(form);

    let login = new EInputGroup("Логин");
        login.appendTo(lCol);

    let email = new EInputGroup("Емайл", 'email');
        email.appendTo(lCol);

    let context = new ETextareaGroup("Описание");
        context.appendTo(lCol);
        
    let cover = new ETaskEditImage();
        cover.appendTo(rCol);
    
    function showPreview( ) {
        preview.addClass("disabled");
        editor.removeClass("disabled");
        
        let data = container.getData();
        let task = new ETask(data);
        view.html(task);

        view.slideDown(100);
        form.slideUp(100);
    }
    
    function showEditor(){
        preview.removeClass("disabled");
        editor.addClass("disabled");
        form.slideDown(100);
        view.slideUp(100);
        view.html("");
    }

    container.setData = function(data) {
        context.setValue(data.context || "");
        cover.setValue(data.cover || "");
        login.setValue(data.login || "");
        email.setValue(data.email || "");
        values = data;
        showEditor();
    };

    container.getData = function(){
        values.context = context.getValue();
        values.login = login.getValue();
        values.email = email.getValue();
        values.cover = cover.getValue();
        return values;
    };

    container.clearData = function(){
        context.setValue("");
        login.setValue("");
        email.setValue("");
        cover.setValue("");
        values = {};
    };

    preview.on("click", showPreview);
    editor.on("click", showEditor);
    return container;
};

let ETaskEditImage = function() {
    let value = "";
    var input = $("<input>", {type: "file"});
    let editor = $("<div>", {"class": "task-image-editor"});
    
    let container = $("<div>", {"class": "image-container"});
        container.appendTo(editor);
    
    let image = $("<img>");
        image.appendTo(container);

    let upload = $("<div>", {"class": "upload-button"});
        upload.appendTo(container);
        upload.text("Загрузить");

    let icon = $("<span>", {"class": "glyphicon glyphicon-remove"});
    let remove = $("<div>", {"class": "remove-button"});
        remove.appendTo(container);
        remove.append(icon);
        remove.hide();
    
    function onFileUploadEvent(event) {
        BJTools.enabledElements([upload, remove]);
        editor.setValue(event.target.path);
    }
    
    editor.setValue = function(path) {
        value = path;

        if (!path) {
            image.attr("src", "");
            image.hide();

            upload.text("Загрузить");
            remove.hide();
        } else {
            image.attr("src", value);
            image.show();

            upload.text("Обновить");
            remove.show();
        }
    };

    editor.getValue = function(){
        return value;
    };

    remove.on("click", function(){
        editor.setValue("");
    });

    upload.on("click", function(){
        input.trigger("click");
    });
    
    input.on("change", function(event) {
        BJTools.disabledElements([upload, remove]);
        BJLoader.upload(event.target.files[0]);
    });

    BJApplication.addListener("file.upload", onFileUploadEvent);

    return editor;
};

let ETaskTool = function(data) {
    let panel = $("<span>", {"class":"task-tool"});
    
    let edit = new EIconButton("cog", "info");
    edit.appendTo(panel);
    
    let state;
    if (data.state == 1) {
        state = new EIconButton("ok", "success");
    } else {
        state = new EIconButton("remove", "danger");
    }
    
    state.appendTo(panel);
    state.on("click", function() {
        data.state = data.state == 1 ? 2 : 1;
        BJTaskEditor.update(data);
    });

    edit.on("click", function() {
        BJTaskEditor.show(data);
    });

    return panel;
};

let ETask = function(data) {

    let state = data.state == 1 ? "primary" : "default";
    let panel = $("<div>", {"class": "panel panel-" + state});
    
    let panelInfo = $("<div>", {"class": "small"});
        panelInfo.append(new EIconInfo("pencil", data.id || 0));
        panelInfo.append(new EIconInfo("calendar", data.createdAt || "00-00-0000 00:00:00"));
        panelInfo.append(new EIconInfo("user", data.login || "login"));

    let panelHead = $("<div>", {"class": "panel-heading"});
        panelHead.append(panelInfo);
        panelHead.appendTo(panel);
    
    let panelBody = $("<div>", {"class": "panel-body"});
        panelBody.appendTo(panel);
    
    if (data.cover) {
        let panelCover = $("<span>", {"class": "panel-cover"});
            panelCover.css("background-image", `url(${data.cover})`);
            panelCover.appendTo(panelBody);
    }
        
    let panelContext = $("<span>", {"class": "panel-context"});
        panelContext.text(data.context || "this is context");
        panelContext.appendTo(panelBody);
    
    panel.showTool = function() {
        panelHead.append(new ETaskTool(data));
    };

    return panel;
};

let ETaskList = function() {
    let admin = false, items = [], index = 1;

    let list = $("#task-list");

    let info = $("<div>", {"class": "alert alert-info"});
        info.text("Ожидание ответа от сервера...");
        list.html(info);
        
    function onCreateTaskEvent(event) {
        if (index != 0) return;

        items.unshift(event.target);
        let last = items.pop();
        redrawList();
    }

    function onUpdateTaskEvent(event) {
        BJTaskFilter.reload();
    }
    
    function onLoadTasksEvent(event) {
        items = event.target.items;
        index = event.target.index;
        redrawList();
    }

    function onUserLogoutEvent(event) {
        admin = false;
        redrawList();
    }

    function onUserLoginEvent(event) {
        admin = true;
        redrawList();
    }

    function onUserAuthEvent(event) {
        admin = true;
        redrawList();
    }

    function redrawList() {
        
        list.html("");
        items.map(function(item) {
            let task = new ETask(item);
            if (admin) task.showTool();
            list.append(task);
        });
    }

    function showEmptyList() {
        list.fadeOut(200, function( ) {
            info.removeClass("alert-info");
            info.addClass("alert-warning");
            info.text("Empty list...");
            list.fadeIn();
        });
    }

    BJApplication.addListener("user.logout", onUserLogoutEvent);
    BJApplication.addListener("user.login", onUserLoginEvent);
    BJApplication.addListener("user.auth", onUserAuthEvent);

    BJApplication.addListener("task.update", onUpdateTaskEvent);
    BJApplication.addListener("task.create", onCreateTaskEvent);
    BJApplication.addListener("task.items", onLoadTasksEvent);

    return list;
};

let BJTaskEditor = (function() {
    let _ = this;

    let form = new ETaskEditForm();
    let modal = new EModal("Редактор задач");
        modal.appendTo("body");
        modal.setBody(form);
    
    modal.on("hidden.bs.modal", function( ) {
        form.clearData();
    });

    modal.on("cancel.bj.modal", function( ) {
        _.hide();
    });

    modal.on("apply.bj.modal", function( ) {
        let data = form.getData();
        
        if (data.id) _.update(data);
        else _.create(data);
        
        _.hide();
    });

    _.create = function(data) {
        BJServer.exec("task-create", {data})
    };

    _.update = function(data) {
        BJServer.exec("task-update", {data});
    };

    _.show = function(data) {
        form.setData(data);
        modal.modal("show");
    };

    _.hide = function() {
        modal.modal("hide");
    };
    
    return _;
})();

let BJTaskFilter = (function( ) {
    let _ = this, state;
    
    _.orders = [
        {"label": "Номер (по убыванию)", "value": "id DESC"},
        {"label": "Номер (по возрастанию)", "value": "id ASC"},
        {"label": "Логин (по убыванию)", "value": "login DESC"},
        {"label": "Логин (по возрастанию)", "value": "login ASC"},
        {"label": "Емайл (по убыванию)", "value": "email DESC"},
        {"label": "Емайл (по возрастанию)", "value": "email ASC"}
    ];

    _.limits = [
        {"label": "3", "value": 3},
        {"label": "5", "value": 5},
        {"label": "10", "value": 10}
    ];

    _.states = [
        {"label": "Все задачи", "value": null},
        {"label": "Только открытые", "value": 1},
        {"label": "Только закрытые", "value": 2}
    ];
    
    function updateState() {

        let filter = {
            order: [state.order.value.split(" ")],
            limit: state.limit.value,
            index: state.index
        };

        if (state.state.value) filter.where = {state: state.state.value};
        BJApplication.dispatch({action: "filter.update", target: state});
        BJServer.exec("task-items", {filter});
    }

    _.changeOrder = function(value) {
        if (state.order == value) return;
        state.order = value;
        updateState();
    };

    _.changeState = function(value) {
        if (state.state == value) return;
        state.state = value;
        state.index = 0;
        updateState();
    };

    _.changeLimit = function(value) {
        if (state.limit == value) return;
        state.limit = value;
        state.index = 0;
        updateState();
    };
    
    _.changePage = function(value) {
        if (state.index == value) return;
        state.index = value;
        updateState();
    };

    _.reset = function() {

        state = {
            order: _.orders[0],
            limit: _.limits[0],
            state: _.states[0],
            index: 0
        };

        updateState();
    };

    _.reload = function(){
        updateState();
    };

    return _;
})();

let BJTask = (function( ) {
    let filter = new ETaskFilter();
    let tasks = new ETaskList();

    let create = $("#task-btn-create");
    create.on("click", function() {
        BJTaskEditor.show({});
    });

    let pagination = new EPagination();
        pagination.appendTo("#task-pagination");
        pagination.hide();
        
    pagination.on("select", function(event, index) {
        BJTaskFilter.changePage(index);
    });

    function construct() {
        filter.fadeIn(300, function( ) {
            tasks.fadeIn(300, BJTaskFilter.reset);
        });
    }

    function onLoadTasksEvent(event) {
        let data = event.target;
        pagination.setList(data.pages, data.index);
        if (data.pages > 1) pagination.show();
        else pagination.hide();
    }

    function onUpdateTaskEvent(event) {
        BJMessages.showSystemMessage(`Update task #${event.target.id} complete`);
    }

    function onCreateTaskEvent(event) {
        BJMessages.showSystemMessage(`Create task #${event.target.id} complete`);
    }

    BJApplication.addListener("task.update", onUpdateTaskEvent);
    BJApplication.addListener("task.create", onCreateTaskEvent);
    BJApplication.addListener("task.items", onLoadTasksEvent);

    BJApplication.addListener("system.init", construct);
})();