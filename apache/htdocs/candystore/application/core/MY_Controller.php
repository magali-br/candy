 <?php

 class MY_Controller extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        
    	session_start();
        header("Cache-Control: no-cache, must-revalidate");
    }

 	public function welcome() {

        if ($this->loggedIn()) {
            
            if (isset($_SESSION["first"])) {
                echo "<p>Welcome to the Candy Store, " . $_SESSION["first"] . "!</p>";
            } else {
                echo "<p> Welcome Nameless One </p>";
            }
            echo "<p>" . anchor('customer_controller/logout','Log Out') . "</p>";
        } else {
            echo "<p>Welcome to the Candy Store, please log in!</p>";
            echo "<p>" . anchor('customer_controller/loginForm','Log In') . "</p>";
        }
    }

    public function loggedIn() {
        if ((isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"])) {
            return true;
        }
        return false;
    }

    public function isAdmin() {
        if ($this->loggedIn() && isset($_SESSION["login"]) 
                && (strcmp($_SESSION["login"], "admin") == 0)) {
            return true;
        }
        return false;
    }
 }

 
