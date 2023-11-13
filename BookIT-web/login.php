<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>BookIT - Login</title>
</head>
<body>
    <!-- Her er logginn-side for brukere -->

    <?php
        function clean($var) {
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
        <label for="uword">Brukernavn:</label>
        <input type="text" id="uword" name="uword" placeholder="Brukernavn">
        <?php echo "<div class='error'>".$error["Brukernavn"]."</div>"; ?>
        
        <label for="pword">Passord:</label>
        <input type="text" id="pword" name="pword" placeholder="Passord">
        <?php echo "<div class='error'>".$error["Passord"]."</div>"; ?>
                
        <input type="login" name="login" value="sent">
    </form>
        
    <?php

        // Funksjon for å sammenligne og verifisere om passord og hash er korrekt.
        /*
        if(password_verify(clean("passord"), $hash)) {
            // Når passordet er korrekt, start session med brukeren.

            session_start();
            $_SESSION['navn'] = "b";
            $_SESSION['id'] = 0;
        }*/
    
    ?>
</body>
</html>