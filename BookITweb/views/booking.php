<?php
/** @var $this \app\core\View */
$this->title = "Booking";
use app\core\form\TextareaField;

//Page for booking after user has logged in.
//Show available bookings

//TODO: Make bookings selectable, and add form for booking selected
?>

<h1>Booking</h1>

<!-- Booking  -->

<div class="row gap-2 mt-2 mb-5">
    <div class="col-md mb-5 bg-white shadow-sm rounded py-2">
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
                    <div>Apply</div>
                    <iconify-icon class="d-flex align-items-center fs-4 ps-2" icon="bx:filter"></iconify-icon>
                </button>
            </div>
            <?php echo \app\core\form\Form::end() ?>

        </div>
        <div class="row mb-5">
            <div class="col py-2">
                <!-- Bookings-overview -->

                <?php
            if (!empty($activeBookingGroups)):
                foreach ($activeBookingGroups as $group):
                ?>

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
                            <div class="booking_info_label" title="Holder"><?php echo $group[0]->getHolder() ?></div>
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

                <?php else: ?>
                <div class="py-2 font_color_grey">No booking times to be found</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md mb-5 bg-white shadow-sm rounded py-2">
        <div class="row">
            <!-- Booking-form -->
            <div class="info font_color_grey py-2"> Click on an available time slot to begin booking.
            </div>
            <?php $form = \app\core\form\Form::begin('/booking/setup', 'post', 'Booking'); ?>
            <?php echo new TextareaField($model, 'booker_note'); ?>
            <?php echo \app\core\form\Form::end(); ?>
        </div>

        <div class="row align-items-end">
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" form="Booking" value="save" class="btn btn-primary d-flex pe-1 <?= ($bookingform->id == 0) ? 'disabled' : '' ?>">
                    <div>Save</div>
                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
</div>

