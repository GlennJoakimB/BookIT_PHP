<?php
    require '../../src/Logic/session_check.php'
    require '../../src/Views/Shared/Header.php'
    require '../../src/Views/Shared/NavBar.php'
?>
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

<?php require '../../src/Views/Shared/Footer.php'; ?>

