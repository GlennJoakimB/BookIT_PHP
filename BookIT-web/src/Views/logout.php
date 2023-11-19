<?php
// Side for utlogging, og har i oppgave å slette session før bruker videresendes til login-siden
session_start();
if (isset($_SESSION['user'])) {
    session_destroy();
    header("Location: ./login.php");
} else {
    // Send brukere til login uansett
    header("Location: ./login.php");
}
?>