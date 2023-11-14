<?php
    session_start();
    if(!isset($_SESSION)) {
        //Redirect to login mayhaps
        header("Location: ../Pages/login.php");
        exit();
    }
?>
<!doctype html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>BookIT - Hovedside</title>
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Style/NavBar.css" />
    <link rel="stylesheet" href="../Style/Footer.css" />

    <!-- Ikoner fra https://icon-sets.iconify.design/bx/ -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>
<body>
    <div id="NavBar">
        <?php include './NavBar.php'; ?>
    </div>
        <?php
        //TODO: logic for displaying switchable content (components)
        
        // For Studenter/brukere
            // TODO: Visning av bookede timer
            // TODO: Knapp for ny boking

        // For veildere
            // TODO: Visning av innboks/bookede timer
            // TODO: Knapp for visning av plan og perioder
        ?>

        <?php include './Footer.php'; ?>
</body>
</html>

