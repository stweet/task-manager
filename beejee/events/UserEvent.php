<?php

namespace beejee\events {

    use stweet\events\Event;
    
    class UserEvent extends Event {
        
        const ON_AFTER_LOGOUT_USER_EVENT = "onAfterLogoutUserEvent";
        const ON_AFTER_LOGIN_USER_EVENT = "onAfterLoginUserEvent";
        const ON_AFTER_AUTH_USER_EVENT = "onAfterAuthUserEvent";
    }
}