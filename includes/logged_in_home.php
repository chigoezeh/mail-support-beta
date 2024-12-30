<?php
    //
?>
<!DOCTYPE html>
<html>
    <?php
        $_page_title = 'Dashboard';
        include_once 'includes/head.php';
    ?>
    <body>
        <?php
            $__set_active = 'lhome';
            include_once 'includes/header.php';
        ?>
        <section>
            <style>
                body {
                    background-color: #f7f7f7;
                }
            </style>
            <div class="row row-md">
                <div class="large-8 medium-8 columns">
                    <div class="padding-st">
                        <h1 class="font-size-30">Dashboard</h1>
                    </div>
                </div>
                <div class="columns large-6 medium-6">
                    <a href="#"><div class="card">
                        <div class="card-body">
                            <p class="text-center"><span class="font-size-40"><?php echo '9.2'; ?></span></p>
                            <p class="text-center"><span class="text-primary mdi mdi-cash"> ...</span></p>
                        </div>
                    </div></a>
                </div>
                <div class="columns large-6 medium-6">
                    <a href="#"><div class="card">
                        <div class="card-body">
                            <p class="text-center"><span class="font-size-40"><?php echo '3.4'; ?></span></p>
                            <p class="text-center"><span class="text-primary mdi mdi-chart-line-variant"> ...</span></p>
                        </div>
                    </div></a>
                </div>
            </div>
        </section>
    </body>
</html>