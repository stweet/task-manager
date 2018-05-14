

let BJApplication = (function(){
    let _ = this;
    let items = [];
    
    _.removeListener = function(action, listener) {
        if (!items[action]) return;

        let index = items[action].indexOf(listener);
        if (index >= 0) items[action].splice(index, 1);
    };

    _.addListener = function(action, listener) {
        if (!items[action]) items[action] = [];

        _.removeListener(action, listener);
        items[action].push(listener);
    };

    _.dispatch = function(event) {
        if (!items[event.action]) return;
        items[event.action].map(function(item) {
            if (typeof item == "function") item(event);
        });
    };

    return _;
})();

let BJMessages = (function(){
    let _ = this;

    _.showSystemMessage = function(message, type) {

        let element = new EMessageInfo(message, type || "info");
            element.appendTo(".system-messages-container");
            element.delay(3000).fadeOut(500, function(){
                element.remove();
            });
    };

    function onMessageEvent(event) {
        let type = event.target.type;
        let message = event.target.message;
        _.showSystemMessage(message, type);
    }

    BJApplication.addListener("system.message", onMessageEvent);
    BJApplication.addListener("user.message", onMessageEvent);
    BJApplication.addListener("file.message", onMessageEvent);
    BJApplication.addListener("task.message", onMessageEvent);
    
    return _;
})();

let BJServer = (function(){
    let _ = this;
    
    _.exec = function(cmd, args) {
        if (!args) args = {};

        $.post(cmd, args, function(json) {
            
            try {
                let up = JSON.parse(json);
                BJApplication.dispatch({
                    target: up.args,
                    action: up.cmd
                });
            } catch (error) {
                console.log(error.message);
                console.log(json);
            }
        });
    };

    return _;
})();

let BJCookie = (function(){
    let _ = this;

    function update(cookies) {
        cookies.push("path=/");
        cookies.push("expires=0");
        document.cookie = cookies.join(";");
    }

    _.clear = function(name) {
        update([name + "="]);
    };

    _.set = function(name, value) {
        update([name + "=" + value]);
    };

    _.get = function(name) {
        let segments = document.cookie.split(";");
        
        for (let i = 0; i < segments.length; i ++) {
            let attr = segments[i].split("=");
            if (attr[0].trim() == name) {
                return attr[1];
            }
        }

        return null;
    };

    return _;
})();

let BJLoader = (function(){
    let _ = this;

    _.upload = function(file) {
        var reader = new FileReader();

        reader.onload = function(event) {
            BJServer.exec('file-upload', {file: {
                name: file.name,
                size: file.size,
                mime: file.type,
                data: reader.result
            }});
        };

        reader.readAsDataURL(file);
    };

    return _;
})();

let BJTools = (function(){
    let _ = this;
    
    _.disabledElements = function(elements) {
        elements.map(function(el) {
            el.attr("disabled", true);
            el.addClass("disabled");
        });
    }
    
    _.enabledElements = function(elements) {
        elements.map(function(el) {
            el.removeAttr("disabled");
            el.removeClass("disabled");
        });
    }

    return _;
})();

let BJAuth = (function( ) {
    let sid = "tzsid";
    let _ = this;

    function onLogoutEvent(event) {
        BJCookie.clear(sid);
    }

    function onLoginEvent(event) {
        BJCookie.set(sid, event.target.sid);
    }

    _.logout = function() {
        let id = BJCookie.get(sid);
        BJServer.exec("user-logout", {id});
    };

    _.login = function(login, password) {
        BJServer.exec("user-login", {login, password});
    };

    BJApplication.addListener("user.logout", onLogoutEvent);
    BJApplication.addListener("user.login", onLoginEvent);
    
    BJApplication.addListener("system.init", function( ) {
        let id = BJCookie.get(sid);
        if (id) BJServer.exec("user-auth", {id});
    });

    return _;
})();

window.addEventListener("load", function() {
    BJApplication.dispatch({action: "system.init"});
});