<?php
    include __DIR__ . '../Shared/Header.php';

    if(isset($_SESSION['user'])){
        include '../Shared/NavBar.php';

    }
    else{
        //unathorized, show login page
        //check if path is set to registration
        include 'login.php';
    }

    include __DIR__ . '../Shared/Footer.php';
?>
