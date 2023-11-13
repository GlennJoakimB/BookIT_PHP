<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>BookIT - Registrering</title>
</head>
<body>
    <!-- Om man ikke har en bruker allerede kan man registrere seg her -->


    <?php
        // Dersom $_Request har en verdi så settes den i variabelen, ellers blir standard gitt verdi brukt
        $lagring = array(
            "Fornavn" => isset($_REQUEST['fname']) ? ucwords(strtolower(clean($_REQUEST['fname']))) : null,
            "Etternavn" => isset($_REQUEST['lname']) ? ucwords(strtolower(clean($_REQUEST['lname']))) : null,
            "Epost" => isset($_REQUEST['epost']) ? filter_var(clean($_REQUEST['epost']), FILTER_SANITIZE_EMAIL) : null,
        );

        // Matrise for feilmeldinger
        $error = array(
            "Fornavn" =>  "TestError",
            "Etternavn" =>  null,
            "Epost" =>  null
        );
        

        // Denne funksjonen fjerner mulighet for skadelig kode som kan sendes gjennom skjemaet.
        function clean($var) {
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
        }
    ?>

    <form method="post">
        <label for="fname">Fornavn:</label>
        <input type="text" id="fname" name="fname" placeholder="Fornavn" value="<?php echo $lagring["Fornavn"]; ?>">
        <?php echo "<div class='error'>".$error["Fornavn"]."</div>"; ?>
        
        <label for="lname">Etternavn:</label>
        <input type="text" id="lname" name="lname" placeholder="Etternavn" value="<?php echo $lagring["Etternavn"]; ?>">
        <?php echo "<div class='error'>".$error["Etternavn"]."</div>"; ?>
        
        <label for="epost">E-post:</label>
        <input type="text" id="epost" name="epost" placeholder="E-post" value="<?php echo $lagring["Epost"]; ?>"> 
        <?php echo "<div class='error'>".$error["Epost"]."</div>"; ?>
                
        <input type="submit" name="save" value="Lagre">
    </form>
    <br>

    <?php
        // Logikk for lagring
        // Printer ut mottatt informasjon på siden
        if (isset($_REQUEST['save'])) {
            if(no_error($error)) {
                echo "<p><strong>Informasjonen er nå lagret.</strong></p>";


            }
            
            echo "<p>Her er verdiene som ble mottatt:</p>
                    <div class='values-grid'>";

            foreach ($lagring as $key => $verdi) {
                echo "<div>$key</div><div>- $verdi</div>";
            }

            echo "</div>";
        }
    ?>

    <?php
        // Validering av fornavn og etternavn
        function validering_navn(string $var, string $input): string {
            if($input == null || $input == "") { return "*$var mangler."; }
            if(strlen($input) <= 1) { return "*$var må bestå av mer enn ett regn."; }
            if(!preg_match("/^[a-zA-Z\s]+$/", $input)) { return "*$var skal bare inneholde bokstaver og mellomrom."; }

            return "";
        }

        // Validerer oppbyggingen av eposten
        function validering_epost(string $input): string {
            global $epost_endings;  // Definerer at global variabel skal brukes lokalt i funksjonen
            
            if($input == null || $input == "") { return "*Epost mangler"; }
            if(!str_contains($input, "@")) { return '*Email må inneholde "@".'; }
            if(!preg_match("/^[a-zA-Z-' ]/",strstr($input, '@', true))) { return '*Bare bokstaver er tillatt i begynnelsen av eposten. Mellomrom er ikke tillatt.'; }
            if(!str_contains($input, ".")) { return "*Eposten må avsluttes med et toppdomene (.com eller .no)."; }
            if(!(strlen(substr(strstr(strstr($input, '@'), ".", true), 1)) >= 1)) { return '*Email må inneholde "@" etterfulgt av et domene på minst ett tegn.'; }
            if(!in_array(substr($input, strrpos($input, ".")), $epost_endings)) { return '*Toppdomenet "'.substr($input, strrpos($input, ".")).'" er ikke godkjent på denne demo-siden.'; }
            if(!filter_var($input, FILTER_VALIDATE_EMAIL)) { return "*Ukjent feil med eposten."; }

            return "";
        }

        // Validere om det er error til stede
        function no_error(array $input): bool {
            $b = true; // Startverdi er true

            // Dersom en error blir funnet settes $b til false
            foreach ($input as $verdi) {
                if($verdi != "") {
                    $b = false;
                }
            }

            // Verdi returneres
            return $b;
        }
    ?>

</body>
</html>