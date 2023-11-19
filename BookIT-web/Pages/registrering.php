<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="..\Style\style.css">
    <title>BookIT - Registrering</title>

    <!-- Ikoner fra https://icon-sets.iconify.design/bx/ -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>

<body>
    <!-- Om man ikke har en bruker allerede kan man registrere seg her -->
    <div id="front_card">
        <div id="logo">
            <div>BookIT</div>
            <iconify-icon icon="bx:book-bookmark"></iconify-icon>
        </div>
        <h1>Registrering</h1>

        <?php
            // Innkluderer ekstern fil for validering
            require '../Logic/input_validation.php';
            
            // Dersom $_Request har en verdi så settes den i variabelen, ellers blir standard gitt verdi brukt
            $lagring = array(
                "Fornavn" => isset($_REQUEST['fname']) ? ucwords(strtolower(clean($_REQUEST['fname']))) : null,
                "Etternavn" => isset($_REQUEST['lname']) ? ucwords(strtolower(clean($_REQUEST['lname']))) : null,
                "Epost" => isset($_REQUEST['epost']) ? filter_var(clean($_REQUEST['epost']), FILTER_SANITIZE_EMAIL) : null,
                "Password" => isset($_REQUEST['p_word']) ? clean($_REQUEST['p_word']) : null,
                "Password_re" => isset($_REQUEST['p_re_word']) ? clean($_REQUEST['p_re_word']) : null
            );

            // Matrise for feilmeldinger
            $error = array(
                "Fornavn" =>  null,
                "Etternavn" =>  null,
                "Epost" =>  null,
                "Password" => null,
                "Password_re" => null
            );

            // Start med å kjøre test på om data har blitt lagret
            if (isset($_REQUEST['save'])) {

                // Validering 
                $error["Fornavn"] = validering_navn("Fornavn", $lagring["Fornavn"]);
                $error["Etternavn"] = validering_navn("Etternavn", $lagring["Etternavn"]);
                $error["Epost"] = validering_epost($lagring["Epost"]);
                $error["Password"] = validering_passord($lagring["Password"]);
                $error["Password_re"] = validering_repeat_passord($lagring["Password"], $lagring["Password_re"]);
            }
        ?>
        

        <form method="post">
            <div class="input_container">
                <label for="fname">Fornavn</label>
                <input type="text" id="fname" name="fname" placeholder="Aa" value="<?php echo $lagring["Fornavn"]; ?>">
                <?php echo "<div class='error'>" . $error["Fornavn"] . "</div>"; ?>
            </div>
            <div class="input_container">
                <label for="lname">Etternavn</label>
                <input type="text" id="lname" name="lname" placeholder="Aa" value="<?php echo $lagring["Etternavn"]; ?>">
                <?php echo "<div class='error'>" . $error["Etternavn"] . "</div>"; ?>
            </div>
            <div class="input_container">
                <label for="epost">E-post</label>
                <input type="text" id="epost" name="epost" placeholder="Aa" value="<?php echo $lagring["Epost"]; ?>">
                <?php echo "<div class='error'>" . $error["Epost"] . "</div>"; ?>
            </div>
            <div class="input_container">
                <label for="p_word">Passord</label>
                <input type="password" id="p_word" name="p_word" value="<?php echo $lagring["Password"]; ?>">
                <?php echo "<div class='error'>" . $error["Password"] . "</div>"; ?>
            </div>
            <div class="input_container">
                <label for="p_re_word">Gjenta passord</label>
                <input type="password" id="p_re_word" name="p_re_word" value="<?php echo $lagring["Password_re"]; ?>">
                <?php echo "<div class='error'>" . $error["Password_re"] . "</div>"; ?>
            </div>
                
            <input class="input_button" type="submit" name="save" value="Registrer">
        </form>
        <br>
        Har du allerede en bruker? <a href="login.php">Logg inn</a>.

        <?php
            // Definere variabler for DataBase-forbindelse
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASS', '');
            define('DB_NAME', 'is115');
            $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

            
            // Logikk for lagring
            // Printer ut mottatt informasjon på siden
            if (isset($_REQUEST['save'])) {
                if (no_error($error)) {
                    echo "<p><strong style='color: #0d0;'>Informasjonen er nå lagret.</strong></p>";
                    
                    
                    // Logikk for lagring
                    // TODO: Send data inn i DB

                    /*
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        exit("Connection failed: " . $conn->connect_error);
                    }*/
                    

                    // Rediriger til hovedside
                    header("Location: ./");
                    exit();
                }


                // ---------------------------------------
                // Print ut mottatte verdier for debugging
                // ---------------------------------------
                echo "<div class='debug'>";
                echo "<div>Her er verdiene som ble mottatt:</div>
                        <div class='values-grid'>";

                foreach ($lagring as $key => $verdi) {
                    echo "<div>$key</div><div>- $verdi</div>";
                }

                echo "</div></div>";
            }
        ?>
    </div>
    </body>
</html>