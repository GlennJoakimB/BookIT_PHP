<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="..\Style\style.css">
    <title>BookIT - Login</title>
</head>

<body>
    <!-- Her er logginn-side for brukere -->
    <div id="front_card">
        <h1>Login</h1>

        <?php
        function clean($var)
        {
            $var = strip_tags($var);
            $var = htmlentities($var);
            $var = trim($var);
            return $var;
        }

        $error = array(
            "Brukernavn" =>  null,
            "Passord" =>  null
        );
        ?>
        <form method="post">
            <div class="input_container">
                <label for="uword">Brukernavn:</label>
                <input type="text" id="uword" name="uword" placeholder="Aa">
                <?php echo "<div class='error'>" . $error["Brukernavn"] . "</div>"; ?>
            </div>
            <div class="input_container">
                <label for="pword">Passord:</label>
                <input type="text" id="pword" name="pword" placeholder="Aa">
                <?php echo "<div class='error'>" . $error["Passord"] . "</div>"; ?>
            </div>

            <input class="input_button" type="submit" name="login" value="Log in">
        </form>
        <br>
        Har du ikke bruker? <a href="registrering.php">Registrer deg her</a>.
    </div>

    <?php

    // Funksjon for å sammenligne og verifisere om passord og hash er korrekt.

    if (password_verify(clean("passord"), $hash)) {
        // Når passordet er korrekt, start session med brukeren.

        session_start();
        $_SESSION['navn'] = "b";
        $_SESSION['id'] = 0;
    }

    ?>
</body>

</html>