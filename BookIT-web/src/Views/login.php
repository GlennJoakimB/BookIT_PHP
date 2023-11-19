
    <!-- Her er logginn-side for brukere -->
    <?php include __DIR__ . '../Shared/Header.php';?>
    <div id="front_card">
        <div id="logo">
            <div>BookIT</div>
            <iconify-icon icon="bx:book-bookmark"></iconify-icon>
        </div>
        <h1>Login</h1>

        <?php
        // Inkluder ekstern fil for validering
        require __DIR__ . '../../Logic/input_validation.php';

        $lagring = array(
            "Username" => isset($_REQUEST['uword']) ? cleanString($_REQUEST['uword']) : null,
            "Password" => isset($_REQUEST['pword']) ? cleanString($_REQUEST['pword']) : null
        );


        //TODO: Fjern senere når ordentlig håndtering kommer
        // Test-bruker
        $user = "Admin";
        $hash = '$2y$10$hUIDMQ3BlJxhfEpen8xbeuloEnpeHRZABlnynBw11Z0oOCMrtDrNu'; // hash for "Tester1" som test-passord:
        //echo password_hash(clean("Tester1"), PASSWORD_DEFAULT)."<br>";


        // ------------------------------------------------------------------
        // Funksjon for å sammenligne og verifisere om passord og hash er korrekt.
        // ------------------------------------------------------------------

        // Test om brukernavn og passord er sendt inn
        if ((isset($_REQUEST['uword']) && $lagring["Username"] != null) &&
            (isset($_REQUEST['pword']) && $lagring["Password"] != null)
        ) {
            //TODO: Benytt brukernavn for å hente passord fra DB, og sammenling passord fra DB (om det finnes) med inntastet passord.
            if (strcmp($lagring["Username"], $user) === 0) {
                // Dersom brukernavn er "funnet":
                if (password_verify($lagring["Password"], $hash)) {
                    // Når passordet er korrekt, start session med brukeren.

                    session_start();
                    $_SESSION['user'] = $lagring["Username"];
                    $_SESSION['id'] = 000;
                    $_SESSION['email'] = "admin@testing.nope";
                    $_SESSION['last_activity'] = time();

                    //TODO: Rediriger til meny
                    header("Location: ./");
                    exit();

                } else {
                    // Skriv ut indirekte feilmelding om at noe er galt
                    echo "<div class='banner_error'>*Feil brukernavn eller passord.</div>";
                }
            } else {
                // Skriv ut indirekte feilmelding om at noe er galt, lik som rett over
                echo "<div class='banner_error'>*Feil brukernavn eller passord.</div>";
            }
        }

        ?>
        <form method="post">
            <div class="input_container">
                <label for="uword">Brukernavn:</label>
                <input type="text" id="uword" name="uword" placeholder="Aa" value="<?php echo $lagring["Username"]; ?>">
            </div>
            <div class="input_container">
                <label for="pword">Passord:</label>
                <input type="password" id="pword" name="pword" placeholder="Aa" value="<?php echo $lagring["Password"]; ?>">
            </div>

            <input class="input_button" type="submit" name="login" value="Log in">
        </form>
        <br>
        Har du ikke bruker? <a href="registrering.php">Registrer deg her</a>.
    </div>
<?php include __DIR__ . '../Shared/Footer.php'; ?>