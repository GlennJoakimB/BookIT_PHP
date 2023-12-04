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
            <?php echo $form->field($model, 'subject') ?>
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

            <div class="rounded border overflow-hidden mb-2">
                <!-- booking head -->
                <div class="d-flex bg-body-tertiary">
                    <div class="shadow-sm date_bg rounded-end border-end" style="min-width: 8rem;">
                        <div class="row d-felx p-1">
                            <div class="col-4 px-3" style="font-size:1.6rem;">
                                <?php
                                $title_time = strtotime($bookingPreview[0]->date);
                                echo date('jS', $title_time);
                                ?>
                            </div>
                            <div class="col" style="font-size: 0.8rem;">
                                <div><?php echo date('l', $title_time); ?></div>
                                <div><?php echo date('M Y', $title_time); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col py-1 px-2">
                        <div class="" title="Subject"><?php echo $bookingPreview[0]->subject ?></div>
                        <div class="booking_info_label" title="Holder"><?php echo $bookingPreview[0]->holder ?></div>
                    </div>
                </div>
                <div class="rounded-bottom overflow-hidden">
                    <?php
                    foreach ($bookingPreview as $bookingSlot): ?>
                        <!-- booking card loops -->
                        <div class="d-flex justify-content-between border-top booking_available?>">
                            <div class="bg-light text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                <?php echo $bookingSlot->getStartTime() . " - " . $bookingSlot->getEndTime(); ?>
                            </div>
                            <div class="d-flex pe-1">
                                <iconify-icon class="d-flex align-items-center fs-4 font_color_wite" icon="bx:chevron-right"></iconify-icon>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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

        <?php
        if (!empty($existingBookingGroups)):
            foreach ($existingBookingGroups as $course => $groups): ?>

                <!-- Course Header -->
                <div class="row border rounded-end-2 bg-body-tertiary p-2 mb-2 fs-5">
                    <div class="col fw-bold"><?php echo $course; ?></div>
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?= str_replace(' ', '', $course) ?>" aria-expanded="false" aria-controls="collapseExample">
                            <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-down"></iconify-icon>
                        </button>
                    </div>
                </div>
                <div class="ms-2 collapse show" id="collapseExample<?= str_replace(' ', '', $course) ?>">
                    <?php
                    foreach ($groups as $group): ?>

                        <div class="rounded border overflow-hidden mb-2">
                            <!-- booking head -->
                            <div class="d-flex bg-body-tertiary">
                                <div class="shadow-sm date_bg rounded-end border-end" style="min-width: 8rem;">
                                    <div class="row d-felx p-1">
                                        <div class="col-4 px-3" style="font-size:1.6rem;">
                                            <?php
                                            $title_time = strtotime($group[0]->start_time);
                                            echo date('jS', $title_time);
                                            ?>
                                        </div>
                                        <div class="col" style="font-size: 0.8rem;">
                                            <div><?php echo date('l', $title_time); ?></div>
                                            <div><?php echo date('M Y', $title_time); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col py-1 px-2">
                                    <div class="" title="Subject"><?php echo $group[0]->subject ?></div>
                                    <div class="booking_info_label" title="Holder"><?php echo $group[0]->holder ?></div>
                                </div>
                            </div>
                            <div class="rounded-bottom overflow-hidden">
                                <?php
                                foreach ($group as $bookingSlot): ?>
                                    <!-- booking card loops -->
                                    <div class="d-flex justify-content-between border-top booking_available">
                                        <div class="bg-light_ text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                            <?php echo $bookingSlot->getStartTime() . " - " . $bookingSlot->getEndTime(); ?>
                                        </div>
                                        <div class="d-flex pe-1">
                                            <iconify-icon class="d-flex align-items-center fs-4 font_color_wite" icon="bx:chevron-right"></iconify-icon>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="py-2 font_color_grey">No booking times created yet</div>
        <?php endif; ?>
    </div>
</div>
