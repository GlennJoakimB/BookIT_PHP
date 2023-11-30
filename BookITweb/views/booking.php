<?php
/** @var $this \app\core\View */
$this->title = "Booking";

use app\core\form\TextareaField;


//Page for booking after user has logged in.
//Show available bookings

//TODO: Add dropdown to filter  by course
//TODO: Add dropdown to filter by Learning Assistant
//TODO: Add view of available bookings
//TODO: Make bookings selectable, and add form for booking selected

?>

<h1>Booking</h1>

<!-- Booking  -->

<div class="row">
    <div class="col">
        <div id="Topbar_booking">
            <!-- Dropdowns -->
            <?php $form = \app\core\form\Form::begin('', 'post') ?>
            <select name="type" id="type">
                <?php
                foreach ($courses as $course) {
                    echo "<option value='celsius'>celsius</option>";
                }
                ?>
            </select>


            <!-- <button type="submit" class="btn btn-primary">Submit</button>-->
            <?php echo \app\core\form\Form::end() ?>
        </div>
        <div id="booking_calendar">
            Available bookings

            <?php

            if ($bookings) {
                foreach ($bookings as $booking) {
                    ?>
                    <div class="container my-4">
                        <div>Booking nr: <?= $booking->id; ?></div>
                        <div>Teacher Assistant: <?= $booking->holder_id; ?></div>
                        <div>Starts: <?= date('Y.m.d H:i', strtotime($booking->start_time)) ?></div>
                        <div>Ends: <?= date('Y.m.d H:i', strtotime($booking->end_time)) ?></div>
                    </div>
                    <?php
                }
            } else {
                //print error message
                echo 'Ingen bookinger funnet';
            }
            ?>
        </div>
    </div>
    <div class="col"> Booking form

    </div>
</div>

