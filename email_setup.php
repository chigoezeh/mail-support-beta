<?php
    //  Require the important configuration file.
    require_once 'config.php';

    //  Check if user is already logged. If false, take user to the log in page.
    if (!ACTIVE_USER_ACCOUNT || ACTIVE_USER_ACCOUNT['USER_TYPE'] !== 'admin') {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html>
    <?php
        $_page_title = 'Email Settings';
        include_once 'includes/head.php';
    ?>
    <body>
        <?php
            $__set_active = 'emse';
            include_once 'includes/header.php';
        ?>
        <section>
            <style>
                body {
                    background-color: #f7f7f7;
                }
            </style>
            <div class="row row-md margin-b-lg">
                <div class="columns">
                    <div style="padding: 12px 0;">
                        <h1 class="font-size-30" style="margin-bottom: 8px;">...</h1>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>