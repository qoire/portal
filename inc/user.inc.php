<?

        // -- User classes ------------------------------------------

        class GuestUser
        {
                var $cookie_id;

                function GuestUser($cookie_id, $uid = '')
                {
                        global $db;
                        global $sess;

                        $this->$cookie_id = $cookie_id;

                        if(empty($uid))
                        {
                                // uid not passed - need to get it, or create one
                                $result = $db->query("SELECT uid FROM user WHERE cookie_id=$cookie_id");
                                //list($uid) = $result->fetchRow();

                                if($uid)
                                {
                                        // returning guest user
                                        $result = $db->query("UPDATE user SET last_visit=CURRENT_DATE(), num_visits=num_visits+1 WHERE uid=$uid");
                                        $this->uid = $uid;
                                }
                                else
                                {
                                        // new user
                                        $result = $db->query("INSERT INTO user (cookie_id, num_visits, last_visit) VALUES($cookie_id, 1, CURRENT_DATE())");
                                        $result = $db->query("SELECT uid FROM user WHERE cookie_id=$cookie_id");
                                        list($this->uid) = $result->fetchRow();
                                }
                                $sess['uid'] = $this->uid;
                        }
                        else
                        {
                                $this->uid = $uid;
                        }

                        $this->clipped_ads = array();

                        return true;
                }

                function authenticate($email, $password, $activate_code = NULL)
                {
                        GLOBAL $sess, $db;

                        // might be someone activating their account
                        if(!empty($activate_code))
                        {
                                if($activate_code == substr(md5(substr($email, 3, 8)), 3, 10))
                                {
                                        $result = $db->query("UPDATE user SET inactive=0 WHERE email='$email'");
                                }
                        }

                        // see if valid email/password
                        $email = strtolower($email);
                        $query = "SELECT uid FROM user WHERE LOWER(email)='$email' AND password=PASSWORD('$password') AND inactive=0";
                        $result = $db->query($query);
                        list($uid) = $result->fetchRow();

                        if($uid)
                        {
                                // valid
                                $this->uid = $uid;
                                $sess['authenticated']=true;
                                $sess['email']=$email;
                                $sess['uid']=$this->uid;
                                return false;
                        }
                        else
                        {
                                // not found - either not valid or not active
                                $result = $db->query("SELECT COUNT(*) FROM user WHERE email='$email' AND inactive=1");
                                list($count) = $result->fetchRow();
                                if($count)
                                {
                                        // not active
                                        return new Error(1, "Your account is not yet active. Navigate to the link in the email sent to your registration email address.");
                                }
                                else
                                {
                                        // invalid
                                        return new Error(1, "The login details you have provided are incorrect.");
                                }
                        }
                }

                function register($email, $password)
                {
                        GLOBAL $db;

                        $email = strtolower($email);

                        $result = $db->query("SELECT COUNT(*) FROM user WHERE email='$email'");
                        list($count) = $result->fetchRow();
                        if($count)
                        {
                                return false;
                        }
                        else
                        {
                                $result = $db->query("INSERT INTO user (email, password, inactive) VALUES('$email', PASSWORD('$password'), 1)");
                                mail($email, "PalmItOff Registration", "Thank you for using PalmItOff.com!\n\nTo complete your registration, navigate to the link below:\n\nhttp://" . $GLOBALS["SERVER_NAME"] . "/" . dirname($GLOBALS["PHP_SELF"]) . "/login.php?e=" . $email . "&c=" . substr(md5(substr($email, 3, 8)), 3, 10) . "\n\n", "From:register@palmitoff.com\n");
                                return true;
                        }
                }


        }

        class AuthUser extends GuestUser
        {
                var $is_authenticated, $email, $password, $uid;
                var $num_visits, $last_visit, $num_syncs, $last_sync;

                function AuthUser($email, $uid)
                {
                        $this->is_authenticated = true;
                        $this->email = $email;
                        $this->uid = $uid;
                        return true;
                }

                function logOut()
                {
                        global $sess;

                        session_unregister($sess);
                        session_destroy();
                        unset($sess);
                }


        }

        class HandheldUser extends AuthUser
        {
                function HandheldUser($handheld_cookie_id)
                {
                        $this->email = $handheld_cookie_id;
                        $this->is_authenticated = false;
                }

                function authenticate()
                {
                        global $db;

                        $result = $db->query("SELECT uid FROM user WHERE email='" . $this->email . "'");
                        list($uid) = $result->fetchRow();

                        if($uid)
                        {
                                $this->is_authenticated = true;
                                $this->uid = $uid;
                        }
                        return $this->is_authenticated;
                }

 
        }
?>