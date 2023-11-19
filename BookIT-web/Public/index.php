<?php require '../Logic/session_check.php' 

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/css/style.css">
    <link rel="stylesheet" href="../Assets/css/NavBar.css" />
    <link rel="stylesheet" href="../Assets/css/Footer.css" />
    <title>BookIT - Hovedside</title>

    <!-- Ikoner fra https://icon-sets.iconify.design/bx/ -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>
<body>
    <?php        
        //TODO: logic for displaying switchable content (components)
        
        // For Studenter/brukere
            // TODO: Visning av bookede timer
            // TODO: Knapp for ny boking
    
        // For veildere
            // TODO: Visning av innboks/bookede timer
            // TODO: Knapp for visning av plan og perioder
    ?>
    
    <div id="NavBar">
        <?php require '../Shared/NavBar.php'; ?>
    </div>
    <div id="Main_content">
        <div id="Current_bookings">
            <div class="title_bar">
                <div class="section_title">Dine bookinger</div>
                <div class="button left_float text_icon_box">
                    Book ny time 
                    <iconify-icon class="icon" icon="bx:plus" width="1.5rem"></iconify-icon>
                </div>
            </div>

            <?php
            // TODO: Legg til logikk for henting og visning av timer

            // Demo-data for testing
            $bookinger = array(
                array(
                    "book_id" => 404,
                    "date" => 20-05-2023,
                    "guide" => "Ferdinand Fernando",
                    "guide_id" => 1234,
                    "course_code" => "IS-310",
                    "topic" => "Tilbakemelding på rapport.",
                    "method" => "Digital",
                    "place" => "https://zoom.com/wololo"
                ),
                array(
                    "book_id" => 101,
                    "date" => 23-05-2023,
                    "guide" => "Donald Duck",
                    "guide_id" => 0303,
                    "course_code" => "IS-115",
                    "topic" => "Godkjenning av modul",
                    "method" => "Fysisk",
                    "place" => "KRS 50 140"
                ),
                array(
                    "book_id" => 404,
                    "date" => 31-06-2023,
                    "guide" => "Ferdinand Fernando",
                    "guide_id" => 1234,
                    "course_code" => "IS-310",
                    "topic" => "Hjelp med kode",
                    "method" => "Fysisk",
                    "place" => "KRS 50 140"
                ),
            );


            //echo "<div class='empty_text'>Ingen bookinger funnet</div>";
            ?>
            <div id="Current_bookings_list">
                <div class="booking_card">
                    
                </div>
                <div class="empty_list">
                    <div class='empty_text'>Du har ingen bookede timer</div>
                </div>
            </div>
        </div>
        <!-- <div id="Booking">
            <a href="Pages/booking.php">Book ny veiledningstime</a>
        </div> -->
    </div>
    <div id="Footer">
        <?php include '../Shared/Footer.php'; ?>
    </div>
</body>
</html>