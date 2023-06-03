<?php
    include_once "Config.php";// definitions of database credentials

    //NOTE: The includes for Controller and Database may need to have their filepaths modified
    require_once "Database.php";// database class: handles db connection and statement execution
    require_once "Controller.php";// handles incoming resp and req calls

    include "login_register.php";// user verification and signup
    include "Reviews.php";// review endpoint
    include "Wineries.php";// wineries endpoint
    include "Wines.php";// wines endpoint


?>