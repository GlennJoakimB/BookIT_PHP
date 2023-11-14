<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="..\Style\style.css">

    <title>BookIT - Registrering</title>
</head>

<body>
    <!-- Om man ikke har en bruker allerede kan man registrere seg her -->
    <div id="front_card">
        <h1>Registrering</h1>

        <?php
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


            // Denne funksjonen fjerner mulighet for skadelig kode som kan sendes gjennom skjemaet.
            function clean($var)
            {
                $var = strip_tags($var);
                $var = htmlentities($var);
                $var = trim($var);
                return $var;
            }

            // SIkkert ikke nødvendig
            $epost_endings = array(
                0 => ".com",
                1 => ".no",
                2 => ".org",
                3 => ".net",
                4 => ".int",
                5 => ".gov"
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
                /*
                if (no_error($error)) {
                    echo "<p><strong>Informasjonen er nå lagret.</strong></p>";
                    // Logikk for lagring
                    // Send data inn i DB

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        exit("Connection failed: " . $conn->connect_error);
                    }
                }*/

                echo "<div class='debug'>";
                echo "<div>Her er verdiene som ble mottatt:</div>
                        <div class='values-grid'>";

                foreach ($lagring as $key => $verdi) {
                    echo "<div>$key</div><div>- $verdi</div>";
                }

                echo "</div></div>";
            }
            // Validering av fornavn og etternavn
            function validering_navn(string $var, string $input): string
            {
                if ($input == null || $input == "") { return "*$var mangler."; }
                if (strlen($input) <= 1) { return "*$var må bestå av mer enn ett regn."; }
                if (!preg_match("/^[a-zA-Z\s]+$/", $input)) { return "*$var skal bare inneholde bokstaver og mellomrom."; }

                return "";
            }

            // Validerer oppbyggingen av eposten
            function validering_epost(string $input): string
            {
                global $epost_endings;  // Definerer at global variabel skal brukes lokalt i funksjonen

                if ($input == null || $input == "") { return "*Epost mangler"; }
                if (!str_contains($input, "@")) { return '*Email må inneholde "@".'; }
                if (!preg_match("/^[a-zA-Z-' ]/", strstr($input, '@', true))) { return '*Bare bokstaver er tillatt i begynnelsen av eposten. Mellomrom er ikke tillatt.'; }
                if (!str_contains($input, ".")) { return "*Eposten må avsluttes med et toppdomene (.com eller .no)."; }
                if (!(strlen(substr(strstr(strstr($input, '@'), ".", true), 1)) >= 1)) { return '*Email må inneholde "@" etterfulgt av et domene på minst ett tegn.'; }
                if (!in_array(substr($input, strrpos($input, ".")), $epost_endings)) { return '*Toppdomenet "' . substr($input, strrpos($input, ".")) . '" er ikke godkjent på denne demo-siden.'; }
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) { return "*Ukjent feil med eposten."; }

                return "";
            }

            function validering_passord(string $input): string
            {
                if ($input == null || $input == "") { return "*Passord mangler."; }
                if (strlen($input) < 6) { return "*Passord kan minst være på 6 tegn."; }
                if (!(preg_match('~[0-9]+~', $input) && 
                preg_match('~[a-z]+~', $input) && 
                preg_match('~[A-Z]+~', $input))) {
                    return "*Passord må ha minst en stor og liten bokstav, og minst ett tall."; }

                return "";
            }

            function validering_repeat_passord(string $input1, string $input2): string {
                if (($input1 != null && $input1 != "") && ($input2 == null || $input2 == "")) { return "*Gjenta passord."; }
                if (strcmp($input1, $input2) !== 0) { return "*Gjentatt passord matcher ikke."; }

                return "";
            }

            // Validere om det er error til stede
            function no_error(array $input): bool
            {
                $b = true; // Startverdi er true

                // Dersom en error blir funnet settes $b til false
                foreach ($input as $verdi) {
                    if ($verdi != "") {
                        $b = false;
                    }
                }

                // Verdi returneres
                return $b;
            }
        ?>
    </div>
    </body>
</html>