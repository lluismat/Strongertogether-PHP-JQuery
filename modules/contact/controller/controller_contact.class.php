<?php
    class controller_contact {

        public function __construct(){
          $_SESSION['module'] = "contact";
        }

        public function loadcontact() {
            require_once(VIEW_PATH_INC."header.php");
			      require_once(VIEW_PATH_INC."menu.php");

            loadView('modules/contact/view/', 'contact.html');

            require_once(VIEW_PATH_INC."footer.html");
        }
    }
