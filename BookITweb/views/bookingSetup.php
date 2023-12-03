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
            <?php echo $form->field($model, 'subject') ?>
            <?php echo new TextareaField($model, 'booker_note') ?>
            <?php echo \app\core\form\Form::end() ?>
        </div>
        <div class="row align-items-end">
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" form="Setup" value="add" class="btn btn-primary d-flex">
                    <div>Add</div>
                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
    <!-- added bookings -->
    <div class="col bg-white d-flex flex-column shadow-sm rounded py-2">
        <h2>Preview</h2>


        <div class="shadow">
            <!-- booking head -->
            <div class="d-flex bg-body-tertiary">
                <div class="shadow-sm bg-light-subtle rounded-end p-2">
                    <div class="fs-4">05</div>
                    12.2023
                </div>
                <div class="col py-1 px-2">
                    <div>
                        <div class="" title="Subject">Workshop</div>
                        <div class="booking_info_label" title="Holder">Tore Super LearningAssistant</div>
                        <div class="booking_info_label" title="Notes"><em>Booking_Note</em></div>
                    </div>
                </div>
            </div>
            <!-- booking card loops -->
            <div class="bg-body-tertiary">
                <div class=""> 14:00 - 14:15
                </div>
            </div>
            <div class="bg-body-tertiary">
                <div class=""> 14:15 - 14:30
                </div>
            </div>
            <div class="bg-body-tertiary">
                <div class=""> 14:30 - 14:45
                </div>
            </div>
            <div class="bg-body-tertiary">
                <div class=""> 14:45 - 15:00
                </div>
            </div>
        </div>



        <?php if (!empty($bookings)):
            foreach ($bookings as $booking): ?>
                <?php echo $booking->course_name ?>
                <?php echo $booking->subject ?>
                <?php echo $booking->booker_note ?>
                <?php echo date('d.m.Y H:i', strtotime($booking->start_time)); ?>
                <?php echo date('d.m.Y H:i', strtotime($booking->end_time)); ?>
            <?php endforeach; else: ?>
            <p>No courses found</p>
        <?php endif; ?>
        <div class="mt-auto d-flex justify-content-end">
            <button type="submit" name="submit" form="Setup" value="create" class="btn btn-primary d-flex <?= empty($bookings) ? 'disabled' : '' ?>">
                <div>Save</div>
                <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
            </button>
        </div>
    </div>
</div>
<div class="row d-none">
    <h2>Existing bookings created by you</h2>
    <?php if (!empty($existingBookings)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Course name</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Start date</th>
                    <th scope="col">End date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($existingBookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking->course_name ?></td>
                        <td><?php echo $booking->subject ?></td>
                        <td><?php echo $booking->booker_note ?></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($booking->start_time)); ?></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($booking->end_time)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No courses found</p>
    <?php endif; ?>
</div>

