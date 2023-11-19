<?php
// En fil for gjenbrukbare funksjoner for filtrering av diverse inputter.

// Fjerner mulighet for skadelig kode som kan sendes gjennom skjemaer
function clean(string $var): string
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = trim($var);
    return $var;
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
    if ($input == null || $input == "") { return "*Epost mangler"; }
    if (!str_contains($input, "@")) { return '*Email må inneholde "@".'; }
    if (!preg_match("/^[a-zA-Z-' ]/", strstr($input, '@', true))) { return '*Bare bokstaver er tillatt i begynnelsen av eposten. Mellomrom er ikke tillatt.'; }
    if (!str_contains($input, ".")) { return "*Eposten må avsluttes med et toppdomene (.com eller .no)."; }
    if (!(strlen(substr(strstr(strstr($input, '@'), ".", true), 1)) >= 1)) { return '*Email må inneholde "@" etterfulgt av et domene på minst ett tegn.'; }
    if (!in_array(substr($input, strrpos($input, ".")), array(".com", ".no", ".org", ".net", ".int", ".gov"))) { return '*Toppdomenet "' . substr($input, strrpos($input, ".")) . '" er ikke godkjent på denne demo-siden.'; }
    if (!filter_var($input, FILTER_VALIDATE_EMAIL)) { return "*Ukjent feil med eposten."; }

    return "";
}

// Validering av passord
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

// Validering om passord og gjentatt passord er korrekt
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