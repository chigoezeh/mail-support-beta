<?php
    //  Require the important configuration file.
    require_once 'config.php';

    //  Check if user is already logged. If true, redirect the user to the dashboard.
    if (ACTIVE_USER_ACCOUNT) {
        header('Location: ../extrigs_supports/');
    }

    //	Check for Log in request.
	$is_error = false;
	if (isset($_POST['login'])) {
		$is_login = true;
		//	Request is sent by a user to log in account.
		$user = $_POST['username'];
		$pword = $_POST['password'];

		$login = $exsup->LogIn($user, $pword);
		if (!$login['success']) {
			$is_error = $login['info'];
		}else {
			$_SESSION['exsup_admin'] = strtolower($user);
			header('Location: ../extrigs_supports/');
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Foreign Exchange Prediction System</title>
        <meta name="description" content="Better predicting environment for users and investors to ease the suffering of predicting currencies for the users of stock market.">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/materialdesignicons.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css?" />
    </head>
    <body>
        <section id="flat-hero">
            <div class="row row-md">
                <div class="large-8 medium-8 columns">
                    <h1>Foreign Exchange</h1>
                    <h2>Prediction System</h2>
                    <h4>Better predicting environment for users and investors to ease the suffering of predicting currencies for the users of stock market.</h4>
                </div>
            </div>
        </section>
        <section>
            <div class="row row-md">
                <div class="large-8 medium-8 columns">
                    <div class="padding-st">
                        <h1 class="font-size-30">Log In</h1>
                    <?php if ($is_error && $is_login): ?>
                        <p style="background: #06a9ac; color: #fff; padding: 8px; margin-top: 0; margin-bottom: 16px; font-size: 12px;"><?php echo $is_error; ?></p>
                    <?php endif; ?>
                        <form action="" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" type="text" value="<?php if ($is_error && $is_login) echo $_POST['username']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password">
                            </div>
                            <div class="text-left">
                                <button class="btn btn-primary" name="login" style="padding: 8px 28px;">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>