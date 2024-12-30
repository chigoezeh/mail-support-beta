<?php

	error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(E_ERROR | E_PARSE);
	//error_reporting(0);
	//ini_set('display_errors', 0);
	session_start(); // Start Session

	header('Cache-control: private'); // IE 6 FIX

	// always modified 
	header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); 
	// HTTP/1.1 
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', false);
	// HTTP/1.0 
    header('Pragma: no-cache');
    
    define('FEPS_DBHOST', 'localhost');
    define('FEPS_DBNAME', 'name_of_db');
    define('FEPS_DBUSER', 'user');
    define('FEPS_DBPASS', 'pw');

	/*Email Sending Configurations*/
    define('EMAIL_CONFIGURATION_NAME', $e_name);
	define('PHPMAILER_HOST', '*************');
	define('PHPMAILER_SMTPAUTH', true);
	define('PHPMAILER_USERNAME', '******@****.com');
	define('PHPMAILER_PASSWORD', '*********');
	define('PHPMAILER_SMTPSECURE', 'tls');
	define('PHPMAILER_PORT', 587);
	define('PHPMAILER_DEFAULT_SENDER', array('******@****.com', 'Shalom from Extrigs!'));
	/*END: Email Sending Configurations*/

    define('RAND_CHARS', '6780cgwYYYY1dZR2ozbVmQa3HC4uYAFJkOp5Wlt6Mqe7KNrhIvGs8yTXxBBBCCCCL9UBnPiED0SfABCacbdefgWWWWhDEabcdefghijklmnoABCDERKJHYTSMJGpqrAAABBBCCCDDDEEEFFFGHHHIIIJJJKKKLLLMMMNNNOOOPPPQQQRRRSSSTTTUUUVVVWWWXXXYYYZZZstuvIIIEUEUIWIWKXNMXDHFGYEUNSNXSNNwxyzFGHIJ1234567890KL123333220992876368GDDTEYYUWUQUJAMAMKXZXHASIHWIJJCUJAJIXHCUUEYYAUHIWQQKKXMXNCBDGHSSUUHC34567890MNOPQRSTUVWXYZ');
	define('RAND_NUM', '0123456789987654321000112233445566778899');
	define('RANDOM_NUM', 'num');
	define('RANDOM_STRING', 'str');


	$db = new PDO("mysql:host=" . FEPS_DBHOST . ";dbname=" . FEPS_DBNAME, FEPS_DBUSER, FEPS_DBPASS);
    //	Throw Error for this database connection.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //	Configure the PDO to return database table rows as associative arrays.
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	//set timezone
	date_default_timezone_set('Africa/Accra'); // I love setting timezone to default GMT.

	//load classes as needed
	spl_autoload_register(function($class) {
	   
		$class = $class;

		//if call from within /assets adjust the path
		$classpath = 'classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}     
	    
		//if call from within admin adjust the path
		$classpath = '../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}
	    
		//if call from within admin adjust the path
		$classpath = '../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}

		//If called from within far ends...
		$classpath = '../../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}

		$classpath = '../../../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}

		$classpath = '../../../../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}

		$classpath = '../../../../../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}

		$classpath = '../../../../../../../classes/' . $class . '.php';
		if (file_exists($classpath)) {
			require_once $classpath;
		}
	});

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'classes/PHPMailer/Exception.php';
	require 'classes/PHPMailer/PHPMailer.php';
	require 'classes/PHPMailer/SMTP.php';

	$phpMailer = new PHPMailer(true);
    
    $exsup = new ExtrigsSupport($db);

    //  Process user logged in status.
    $exist_active_user = false;
    if (isset($_SESSION['exsup_admin']) && $_SESSION['exsup_admin'] !== '') {
        //	A user is probably logged in, let's confirm.
		//	Pull out the user credetials.
		$user_data = $exsup->UserAccountData($_SESSION['exsup_admin']);
        //  Check if the user credential pull successfully returned any valid information.
		if ($user_data['result']) {
			//	It returned a valid user information.
            //  Assign the user data to rhe active constant.
			$exist_active_user = $user_data['result'];
        }else {
            $_SESSION['exsup_admin'] = '';
        }
    }
    define('ACTIVE_USER_ACCOUNT', $exist_active_user);

?>