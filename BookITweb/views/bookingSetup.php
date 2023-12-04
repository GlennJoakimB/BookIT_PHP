<?php
/** @var $this \app\core\View */
$this->title = "New Bookings";

use app\core\form\TextareaField;
use app\core\form\SelectField;


//Page for booking after user has logged in.
//Show available bookings

//TODO: Add form for creating new bookings as LA
//TODO: Add course, date, perido, duration of each?, comment

?>

<!--<h1>Set up page</h1>-->

<div class="row gap-2 mb-5">
    <div class="col bg-white shadow-sm rounded py-2">
        <div class="row">
            <h2>Set up new available booking</h2>

            <?php $form = \app\core\form\Form::begin('/booking/setup', 'post', 'Setup') ?>
            <?php echo $form->selectionField($model, 'course_id')->setOptions($courses) ?>
            <?php echo $form->field($model, 'date')->dayField() ?>
            <div class="row">
                <div class="col">
                    <?php echo $form->field($model, 'start_time')->timeField() ?>
                </div>
                <div class="col">
                    <?php echo $form->field($model, 'end_time')->timeField() ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo $form->selectionField($model, 'booking_duration')->setOptions($duration) ?>
                </div>
                <div class="col">
                    <?php echo $form->selectionField($model, 'break')->setOptions($breakList) ?>
                </div>
            </div>
            <?php echo $form->field($model, 'subject') ?>
            <?php echo \app\core\form\Form::end() ?>
        </div>
        <div class="row align-items-end">
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" form="Setup" value="add" class="btn btn-secondary d-flex pe-1">
                    <div>Preview</div>
                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
    <!-- added bookings -->
    <div class="col bg-white d-flex flex-column shadow-sm rounded py-2">
        <h2>Preview</h2>

        <?php if (!empty($bookingPreview)): ?>
            <div class="border mb-3">
                <!-- booking head -->
                <div class="d-flex bg-body-tertiary">
                    <div class="shadow-sm bg-light-subtle rounded-end border-end p-1 px-2">
                        <div class="fs-4"><?php echo date('l jS', strtotime($bookingPreview[0]->date)); ?></div>
                        <?php echo date('M Y', strtotime($bookingPreview[0]->date)); ?>
                    </div>
                    <div class="col py-1 px-2">
                        <div class="" title="Subject"><?php echo $bookingPreview[0]->subject ?></div>
                        <div class="booking_info_label" title="Holder"><?php echo $bookingPreview[0]->getHolder() ?></div>
                    </div>
                </div>

                <?php foreach ($bookingPreview as $booking): ?>
                    <!-- booking card loops -->
                    <div class="d-flex justify-content-between border-top">
                        <div class="bg-light rounded-end p-1 pe-4 border-end"><?php echo $booking->getStartTime() . " - " . $booking->getEndTime(); ?></div>
                        <div class="d-flex pe-1">
                            <iconify-icon class="d-flex align-items-center fs-4 font_color_grey" icon="bx:chevron-right"></iconify-icon>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <div class="py-2 font_color_grey">No booking created yet</div>

        <?php endif; ?>
        <div class="mt-auto d-flex justify-content-end">
            <button type="submit" name="submit" form="Setup" value="save" class="btn btn-primary d-flex pe-1 <?= empty($bookingPreview) ? 'disabled' : '' ?>">
                <div>Save</div>
                <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
            </button>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col bg-white shadow-sm rounded py-2">

        <h2>Existing bookings created by you</h2>


        <?php if (!empty($existingBookings)):
            foreach ($existingBookings as $course => $groups): ?>
                <div class="border rounded-top bg-body-tertiary p-2 fs-5"><?php echo $course; ?></div>

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
                            <div class="d-flex justify-content-between border-top">
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
