<?php
require_once 'include/config.php';
class AccountManager
{
    private const  CONNECTED_USER_ID_KEY='connected_user_id';
    private  string $connectedUserId='';
    private  $logged_in=false;
    private static ?AccountManager $instance=null;
    private function __construct()
    {
        $this->logged_in=isset($_SESSION[self::CONNECTED_USER_ID_KEY]) AND !empty($_SESSION[self::CONNECTED_USER_ID_KEY]);
        if($this->logged_in){
            $this->connectedUserId=$_SESSION[self::CONNECTED_USER_ID_KEY];
        }
    }
    public function login(string $userId){
        global $session_time_out_minutes;
        // server should keep session data for a certain number of seconds
        ini_set('session.gc_maxlifetime', $session_time_out_minutes*60);
        // each client should remember their session id for for a certain number of seconds
        session_set_cookie_params($session_time_out_minutes*60);
        session_start();
        $_SESSION[self::CONNECTED_USER_ID_KEY]=$userId;
        echo 'suer id '.$_SESSION[self::CONNECTED_USER_ID_KEY];

    }
    public function logOut(){
        session_destroy();
    }
    public function isLoggedIn():bool{
        return $this->logged_in;
    }

    /**
     * creates a new instance and stores it in the $instance static variable
     * @return AccountManager
     */
    public static function getInstance():AccountManager{
        if(!AccountManager::$instance)
            AccountManager::$instance=new AccountManager();
        return AccountManager::$instance;
    }





}