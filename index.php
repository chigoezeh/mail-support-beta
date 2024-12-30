<?php
    //  Require the important configuration file.
    require_once 'config.php';

    //  Check if user is already logged. If true, feed the user with the dasboard view.
    if (ACTIVE_USER_ACCOUNT && ACTIVE_USER_ACCOUNT['USER_TYPE'] === 'admin') {
        include_once 'includes/logged_in_home.php';
    }else {
        //
    }
?>