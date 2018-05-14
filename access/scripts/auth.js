
let WAuth = function() {

    let element = $("#widget-auth");
    let inputTab = element.find("#user-input");
    let infoTab = element.find("#user-info");
    let iLogin = inputTab.find("#user-login");
    let iPassword = inputTab.find("#user-password");
    let loginButton = inputTab.find("#login-button");
    let logoutButton = infoTab.find("#logout-button");

    function onMessageEvent(event) {
        BJTools.enabledElements([iLogin, iPassword, loginButton]);
    }

    function onLogoutEvent(event) {
        infoTab.find("u").text("");
        inputTab.slideDown(200);
        infoTab.slideUp(200);
    }

    function onLoginEvent(event) {
        infoTab.find("u").text(event.target.login);
        infoTab.slideDown(200);
        inputTab.slideUp(200);
        iPassword.val("");
        iLogin.val("");
    }
    
    function onAuthEvent(event) {
        infoTab.find("u").text(event.target.login);
        inputTab.hide();
        infoTab.show();
    }

    function clickLogin(event) {
        let p = iPassword.val().trim();
        let u = iLogin.val().trim();

        if (!/^\w{1,}$/.test(p)) return alert("Укажите пароль!");
        if (!/^\w{1,}$/.test(u)) return alert("Укажите логин!");
        BJTools.disabledElements([iLogin, iPassword, loginButton]);
        BJAuth.login(u, p);
    }

    function clickLogout(event) {
        BJTools.enabledElements([iLogin, iPassword, loginButton]);
        BJAuth.logout();
    }
    
    BJApplication.addListener("user.message", onMessageEvent);
    BJApplication.addListener("user.logout", onLogoutEvent);
    BJApplication.addListener("user.login", onLoginEvent);
    BJApplication.addListener("user.auth", onAuthEvent);
    
    logoutButton.on("click", clickLogout);
    loginButton.on("click", clickLogin);
    infoTab.hide();
    return element;
};

window.addEventListener("load", function(event) {
    return new WAuth().delay(100).slideDown(300);
});