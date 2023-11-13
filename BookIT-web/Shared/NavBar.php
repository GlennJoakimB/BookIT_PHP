<?php
// the navbar component is a php file that is included in every page that needs it.
// it is included in the index.php file, and the admin.php file.
// it is not included in the login.php , register.php or logout.php files.

//Making the navbar container
echo '<div class="navbar">';
//Making the navbar logo
echo '<a href="index.php" class="logo">BookIT</a>';
//Making the navbar links
echo '<div class="navbar-right">';
echo '<a href="index.php">Hjem</a>';
echo '<a href="index.php">Om oss</a>';
echo '<a href="index.php">Kontakt oss</a>';
echo '<a href="index.php">FAQ</a>';
echo '<a href="index.php">Logg inn</a>';
echo '</div>';
//Closing the navbar container
echo '</div>';
?>

