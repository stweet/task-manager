<?php

namespace beejee\models {

    use stweet\models\ModelAttributes;
    
    class TaskAttributes extends ModelAttributes {
        
        const LIST_ALLOW_FIELDS = ['login', 'email', 'cover', 'context', 'state'];
    }
}