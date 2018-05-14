<div class="panel panel-default" id="widget-auth" style="display: none;">
    <div class="panel-heading">Профиль</div>
    <div class="panel-body" id="user-input">
        <div class="form-group">
            <label for="user-login">Логин:</label>
            <input type="text" class="form-control" id="user-login" placeholder="Login"/>
        </div>
        <div class="form-group">
            <label for="user-pass">Пароль:</label>
            <input type="password" class="form-control" id="user-password" placeholder="Password"/>
        </div>
        <hr/>
        <div class="form-group" style="margin-bottom: 0;">
            <button type="button" class="btn btn-block btn-success" id="login-button">Вход</button>                
        </div>
    </div>
    <div class="panel-body" id="user-info">
        <p>Добро пожаловать: <u></u></p>
        <hr/>
        <button type="button" class="btn btn-block btn-primary" id="logout-button">Выход</button>
    </div>
</div>