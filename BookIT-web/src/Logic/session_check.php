<?php
session_start();

// Sjekk om session eksisterer,.
if (!isset($_SESSION['user'])) {
    //Redirect to login mayhaps
    header("Location: ./login.php");
    exit();
}

// Sjekk hvor gammel session er
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage

    header("Location: ./login.php");
    exit();
}
$_SESSION['last_activity'] = time(); // update last activity time 