<?php

    class ExtrigsSupport {

        public function __construct($db) {
            $this->db = $db;
            $this->return = array(
                'success'   =>  false,
                'info'      =>  'Unable to complete the request.'
            );
        }

        function SendMail($email, $name, $subj, $msg, $files = [], $from = null) {
            global $phpMailer;
            try {
                $phpMailer->ClearAllRecipients();
                $phpMailer->clearAttachments();
                $phpMailer->ClearAddresses();
                $phpMailer->SMTPDebug = 0;
                $phpMailer->isSMTP();
                $phpMailer->Host = PHPMAILER_HOST;
                $phpMailer->SMTPAuth = PHPMAILER_SMTPAUTH;
                $phpMailer->Username = PHPMAILER_USERNAME;
                $phpMailer->Password = PHPMAILER_PASSWORD;
                foreach ($files as $value) {
                    $phpMailer->addAttachment($value);
                }
                $phpMailer->SMTPSecure = PHPMAILER_SMTPSECURE;
                $phpMailer->Port = PHPMAILER_PORT;
                if ($from) {
                    $phpMailer->setFrom($from[0], $from[1]);
                }else {
                    $phpMailer->setFrom(PHPMAILER_DEFAULT_SENDER[0], PHPMAILER_DEFAULT_SENDER[1]);
                }
                if (is_array($email)) {
                    for ($i = 0; $i < count($email); $i++) {
                        $phpMailer->addAddress($email[$i], $name[$i]);
                    }
                }else {
                    $phpMailer->addAddress($email, $name);
                }
                $phpMailer->isHTML(true);
                $phpMailer->Subject = $subj;
                $phpMailer->Body = $msg;
                $phpMailer->send();
    
                return true;
            } catch (Exception $e) {
                return $e;
            }
            return false;
        }

        public function LogIn($user, $pword) {
            $username = strtolower($this->TestValidateInput($user));
            try {
                $db_table = 'user_accounts';
                $sql = $this->db->prepare("SELECT * FROM $db_table WHERE username=?");
                $sql->execute(array($username));
                $user_account = $sql->fetch(PDO::FETCH_ASSOC);
                if ($user_account) {
                    //  User account found. Compare the password if it's match.
                    $actual_password = $user_account['softcode'];
                    if ($pword === $actual_password) {
                        //  Log in is successful.
                        return array(
                            'success'   =>  true,
                            'info'      =>  'Log in successful.'
                        );
                    }else {
                        return array(
                            'success'   =>  false,
                            'info'      =>  'You\'ve entered an incorrect password.',
                            'password_error'    =>  true,
                        );
                    }
                }else {
                    return array(
                        'success'   =>  false,
                        'info'      =>  'That user account was not found.'
                    );
                }
            } catch (PDOException $e) {
                return $this->return;
            }
            return array(
                'success'   =>  false,
                'info'      =>  'unexpected termination of process.'
            );
        }

        /**
         * Request user account advanced (all) data.
         * Two ways retrieval of user account information:
         * * (`1`) Single: Retrieve a particular user account information,
         * * (`2`) Bulk: Retrieval of user account information,
         * @param string|bool $query_string The string representing the key query.
         * @param string|bool $string_which The kind of string it represents, either username, identifier, email, or id.
         * @param bool $is_bulk Specifies whether to force bulk retrieval process.
         * @param string|int|bool $limit Number of count for this process.
        */
        public function UserAccountData($query_string = false, $string_which = 'USERNAME', $is_bulk = false, $limit = false) {
            $setLimit = "";
            if ($limit) $setLimit = " LIMIT $limit";
            $c = 'username';
            if ($string_which === 'USER_ID') $c = 'user_id';
            if ($string_which === 'EMAIL') $c = 'email_address';
            if ($string_which === 'USER_UID') $c = 'user_uid';
            if ($string_which === 'USERNAME') $c = 'username';

            try {
                $db_table = 'user_accounts';
                $sql_stmt = "SELECT * FROM $db_table";
                $considerBulkAction = true;
                if (!$query_string || $query_string === true) {
                    $sql_stmt .= " ORDER BY signup_date DESC $setLimit";
                    $sql = $this->db->prepare($sql_stmt);
                    $sql->execute();
                    $resultSet = $sql->fetchall(PDO::FETCH_ASSOC);
                }else {
                    $sql_stmt .= " WHERE $c=? ORDER BY signup_date DESC $setLimit";
                    $sql = $this->db->prepare($sql_stmt);
                    $st = strtolower($query_string);
                    if ($string_which === 'USER_UID') $st = strtoupper($query_string);
                    $sql->execute(array($st));
                    if ($is_bulk) {
                        $resultSet = $sql->fetchall(PDO::FETCH_ASSOC);
                    }else {
                        $resultSet = $sql->fetch(PDO::FETCH_ASSOC);
                        $considerBulkAction = false;
                    }
                }
                $_resultSet = [];
                if (!$considerBulkAction) {
                    if ($resultSet) $_resultSet[] = $resultSet;
                }else {
                    $_resultSet = $resultSet;
                }
                $_r = [];
                foreach ($_resultSet as $r) {
                    $verified = false;
                    if ($r['is_verified'] * 1 === 1) {
                        $verified = true;
                    }

                    $_r[] = array(
                        'ID'                =>  $r['user_id'],
                        'UID'               =>  $r['user_uid'],
                        'USERNAME'          =>  strtolower($r['username']),
                        'FIRST_NAME'        =>  $r['first_name'],
                        'SURNAME'           =>  $r['last_name'],
                        'FULL_NAME'         =>  $r['first_name'] . ' ' . $r['last_name'],
                        'USER_TYPE'         =>  strtolower($r['login_type']),
                        'EMAIL'             =>  strtolower($r['email_address']),
                        'IS_VERIFIED'       =>  $verified,
                        'ACCOUNT_DATE'      =>  $r['signup_date'],
                    );
                }
                if (!$considerBulkAction) {
                    $_r = $_r[0];
                }
                return array(
                    'success'       =>  true,
                    'info'          =>  'Record set might be empty.',
                    'result'        =>  $_r,
                    'is_bulk'       =>  $considerBulkAction,
                );
            } catch (PDOException $e) {
                return $this->return;
            }
        }

        /**
         * Validae user name to see if it meets up with standard naming.
         * @param string $n The name to be validated.
        */
        public function ValidateName($n) {
            if (preg_match("/^[a-zA-Z ']*$/", $n)) {
                return true;
            }
            return false;
        }

        /**
         * Validae username.
         * @param string $u The string to be validated.
        */
        public function ValidateUsername($u) {
            if (preg_match('/^[a-zA-Z0-9]{5,}$/', $u)) {
                return true;
            }
            return false;
        }

        /**
         * Validae email address.
         * @param string $e The string to be validated.
        */
        public function ValidateEmail($e) {
            if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }

        public function TestValidateInput($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            //$input = filter_var($input);
            return $input;
        }

        public function RandomToken($l = 15, $type = RANDOM_STRING) {
            if ($type == RANDOM_NUM) {
                $c = RAND_NUM;
            }else if ($type == RANDOM_STRING) {
                $c = RAND_CHARS;
            }else {
                $c = RAND_CHARS;
            }
            srand((double)microtime()*1000000);
            $i = 0;
            $cl = $l - 1;
            $p = '' ;
            while ($i <= $cl) {
                $num = rand() % 33;
                $tmp = substr($c, $num, 1);
                $p = $p . $tmp;
                $i++;
            }
            return $p;
        }

        function StandardDateFormat($date, $showDate = true, $showTime = false, $showDay = true) {
            $timestamp = strtotime($date);
            //12th June, 2020 at 07:11 pm
            if ($showDay) {
                $setDate = date('l, jS F, Y', $timestamp);
            }else {
                $setDate = date('jS F, Y', $timestamp);
            }
            $setTime = date('g:i a', $timestamp);
            if (!$showDate && $showTime) {
                return $setTime;
            }else if ($showDate && !$showTime) {
                return $setDate;
            }else if ($showDate && $showTime) {
                return $setDate . ' at ' . $setTime;
            }
        }

        public function TimeStamp($d = null) {
            if (!$d) {
                $datetime = date('Y-m-d H:i:s');
            }else {
                $datetime = date('Y-m-d H:i:s', $d);
            }
            return $datetime;
        }
    }

?>