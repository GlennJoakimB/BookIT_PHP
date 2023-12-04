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

<div class="row gap-2 mb-5">
    <div class="col mb-5 bg-white shadow-sm rounded py-2">
        <div class="row">
            <!-- Dropdowns -->
            <?php $form = \app\core\form\Form::begin('', 'post', 'Search') ?>
            <div class="col">
                <?php echo $form->selectionField($model, 'course_id')->setOptions($courses) ?>
            </div>
            <div class="col">
                <?php echo $form->selectionField($model, 'holder_id')->setOptions($la) ?>
            </div>
            <div class="d-flex mb-3 mt-auto justify-content-center">
                <button type="submit" name="submit" form="Search" value="search" class="btn btn-primary d-flex pe-1">
                    <div>Search</div>
                    <iconify-icon class="d-flex align-items-center fs-4 ps-2" icon="bx:search"></iconify-icon>
                </button>
            </div>
            <?php echo \app\core\form\Form::end() ?>

        </div>
        <div class="row">
            <!-- Bookings-overview -->
            <div class="">

                <!--<h2>Active booking slots</h2>-->

                <?php
                if (!empty($bookings)):
                    foreach ($bookings as $course => $groups): ?>
                <div class="border rounded-top bg-body-tertiary p-2 fs-5">
                    <?php echo $course; ?>
                </div>

                <?php
                        foreach ($groups as $bookings): ?>

                <div class="border mb-2">
                    <!-- booking head -->
                    <div class="d-flex bg-body-tertiary">
                        <div class="shadow-sm bg-light-subtle rounded-end border-end p-1 px-2" style="min-width: 11rem;">
                            <div class="fs-4"><?php echo date('l jS', strtotime($bookings[0]->start_time)); ?></div>
                            <?php echo date('M Y', strtotime($bookings[0]->start_time)); ?>
                        </div>
                        <div class="col py-1 px-2">
                            <div class="" title="Subject"><?php echo $bookings[0]->subject ?></div>
                            <div class="booking_info_label" title="Holder"><?php echo $bookings[0]->getHolder() ?></div>
                        </div>
                    </div>

                    <?php
                                foreach ($bookings as $booking): ?>
                    <!-- booking card loops -->
                    <div class="d-flex justify-content-between border-top  <?= ($booking->status == 0) ? 'booking_unavailable' : 'booking_available' ?>">
                        <div class="bg-light rounded-end p-1 pe-4 border-end" style="min-width: 8rem;">
                            <?php echo $booking->getStartTime() . " - " . $booking->getEndTime(); ?>
                        </div>
                        <div class="d-flex pe-1">
                            <iconify-icon class="d-flex align-items-center fs-4 font_color_grey" icon="bx:chevron-right"></iconify-icon>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <?php endforeach; ?>

                <?php else: ?>
                <div class="py-2 font_color_grey">No booking times created yet</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col mb-5 bg-white shadow-sm rounded py-2">
        <div class="row">
            <!-- Booking-form -->
            <?php $form = \app\core\form\Form::begin('/booking/setup', 'post', 'Booking'); ?>            
            <?php echo new TextareaField($model, 'booker_note'); ?>
            <?php echo \app\core\form\Form::end(); ?>
        </div>
        
        <div class="row align-items-end">
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" form="Booking" value="save" class="btn btn-primary d-flex pe-1">
                    <div>Save</div>
                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
</div>

