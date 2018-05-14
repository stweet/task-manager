
let EIconInfo = function(icon, info) {
    let element = $("<span>", {"class": "panel-info-item"});
    $("<span>", {"class": "glyphicon glyphicon-" + icon}).appendTo(element);
    $("<span>").text(info).appendTo(element);
    return element;
};

let EIconButton = function(icon, type) {
    let element = $("<a>", {"href": "javascript:void(0)", "class": "text-" + type});
    $("<span>", {"class": "glyphicon glyphicon-" + icon}).appendTo(element);
    return element;
}

let ETextareaGroup = function(title) {
    let group = $("<div>", {"class": "form-group"});
    
    let label = $("<label>");
        label.appendTo(group);
        label.text(title);
    
    let input = $("<textarea>", {"class": "form-control"});
        input.appendTo(group);
    
    group.getValue = function(){
        return input.val();
    };

    group.setValue = function(value) {
        input.val(value);
    };
    
    return group;
};

let EInputGroup = function(title, type) {
    let group = $("<div>", {"class": "form-group"});
    
    let label = $("<label>");
        label.appendTo(group);
        label.text(title);
    
    let input = $("<input>", {"class": "form-control", "type": type || 'text'});
        input.appendTo(group);
    
    group.getValue = function(){
        return input.val();
    };

    group.setValue = function(value) {
        input.val(value);
    };
    
    return group;
};

let EPagination = function() {
    let pagination = $("<ul>", {"class": "pagination"});

    pagination.setList = function(count, active) {
        pagination.html("");
        
        for (let i = 0; i < count; i ++) {
            let a = $("<a>", {"href": "javascript:void(0)"});
                a.text(i + 1);
            
            if (active != i) a.on("click", function(){
                pagination.trigger("select", i);
            });
            
            let li = $("<li>");
                li.appendTo(pagination);
                li.append(a);

            if (i == active) li.addClass("active");
        }
    };

    return pagination;
};

let EMessageInfo = function(message, type) {
    let element = $("<div>", {"class": "system-message " + type});
        element.text(message);
    return element;
};

let ESelect = function(title) {

    let label = $("<span>");
        label.css({"margin-right": "6px"});
        label.text(title);

    let caret = $("<span>", {"class": "caret"});
    let iList = $("<ul>", {"class": "dropdown-menu"});

    let button = $("<button>", {
        "class": "btn btn-default dropdown-toggle",
        "data-toggle": "dropdown",
        "aria-haspopup": "true",
        "aria-expanded": "true",
        "type": "button"
    });
    
    button.append(label);
    button.append(caret);
    
    let select = $("<div>", {"class": "btn-group"});
        select.append(button);
        select.append(iList);

    select.setTitle = function(title) {
        label.text(title);
    };

    select.setList = function(list) {
        iList.html("");

        list.map(function(data) {

            let a = $("<a>", {"href":"javascript:void(0)"});
                a.on("click", function(){select.trigger("select", data);});
                a.text(data.label);
                
            let li = $("<li>");
                li.append(a);

            iList.append(li);
        });
    };

    return select;
};

let EModal = function(title) {
    let modal = $("<div>", {"class": "modal fade", "tabindex": "-1", "role": "dialog"});
    
    let modalDialog = $("<div>", {"class": "modal-dialog modal-lg", "role": "document"});
        modalDialog.appendTo(modal);

    let modalContent = $("<div>", {"class": "modal-content"});
        modalContent.appendTo(modalDialog);
    
    let modalHeader = $("<div>", {"class": "modal-header"});
        modalHeader.appendTo(modalContent);
    
    let modalHeadrClose = $("<button>", {"class": "close", "type": "button", "data-dismiss": "modal"});
        modalHeadrClose.appendTo(modalHeader);
        modalHeadrClose.html("&times;");
    
    let modalTitle = $("<h4>", {"class": "modal-title"});
        modalTitle.text(title || "Beejee task editor");
        modalTitle.appendTo(modalHeader);
    
    let modalBody = $("<div>", {"class": "modal-body"});
        modalBody.appendTo(modalContent);
    
    let modalFooter = $("<div>", {"class": "modal-footer"});
        modalFooter.appendTo(modalContent);
    
    let modalFooterApply = $("<button>", {"class": "btn btn-primary", "type": "button"});
        modalFooterApply.appendTo(modalFooter);
        modalFooterApply.text("Выполнить");

    let modalFooterCancel = $("<button>", {"class": "btn btn-default", "type": "button"});
        modalFooterCancel.appendTo(modalFooter);
        modalFooterCancel.text("Отменить");

    modalFooterCancel.on("click", function() {
        modal.trigger("cancel.bj.modal");
    });

    modalFooterApply.on("click", function() {
        modal.trigger("apply.bj.modal");
    });

    modal.clearBody = function(child) {
        modalBody.html("");
    };

    modal.setBody = function(child) {
        modalBody.append(child);
    };
    
    return modal;
};