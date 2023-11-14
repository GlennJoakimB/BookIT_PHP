<?php
?>
<!doctype html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>BookIT - Hovedside</title>
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Style/NavBar.css" />
    <link rel="stylesheet" href="../Style/Footer.css" />
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

