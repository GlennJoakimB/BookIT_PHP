<?php
/** @var $this \app\core\View */
$this->title = "Booking";
use app\core\form\TextareaField;

//Page for booking after user has logged in.
//Show available bookings

?>

<h1>Booking</h1>

<!-- Booking  -->

<div class="row gap-2 mt-2 mb-5">
    <div class="col-md mb-5 bg-white shadow-sm rounded py-2">
        <div class="row">
            <!-- Dropdowns -->
            <?php $form = \app\core\form\Form::begin('', 'post', 'Search') ?>
            <div class="col">
                <?php echo $form->selectionField($model, 'course_id_search')->setOptions($courses) ?>
            </div>
            <div class="col">
                <?php echo $form->selectionField($model, 'holder_id_search')->setOptions($la) ?>
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
            <form action="/" method="post" class="col py-2">
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
                                    <?php
                                    if ($bookingSlot->booker_id == 0): ?>
                                        <button class="w-100 remove-button-wrapper" type="submit" name="submit" form="Search" value="booking:<?= $bookingSlot->id ?>">
                                            <div class="d-flex justify-content-between border-top booking_available">
                                                <div class="bg-white text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                                    <?php echo $bookingSlot->getStartTime() . " - " . $bookingSlot->getEndTime(); ?>
                                                </div>
                                                <div class="d-flex pe-1 icon_hover font_color_grey">
                                                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                                                </div>
                                            </div>
                                        </button>
                                    <?php else: ?>
                                        <div class="d-flex justify-content-between border-top booking_unavailable">
                                            <div class="bg-white text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                                <?php echo $bookingSlot->getStartTime() . " - " . $bookingSlot->getEndTime(); ?>
                                            </div>
                                            <div class="d-flex pe-1">
                                                <iconify-icon class="d-flex align-items-center fs-4 font_color_grey" icon="bx:minus"></iconify-icon>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="py-2 font_color_grey">No booking times to be found</div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="col-md mb-5 py-3 bg-white shadow-sm rounded py-2">
        <div class="row">
            <!-- Booking-form -->
            <?php if ($model->id == 0): ?>
                <div class="info font_color_grey py-2"> Click on an available time slot to begin booking.
                </div>
            <?php else: ?>
                <h3>Selected booking</h3>
                <div class="col mt-3">
                    <div class="rounded border overflow-hidden mb-2">
                        <div class="d-flex bg-body-tertiary">
                            <div class="shadow-sm date_bg rounded-end border-end" style="min-width: 8rem;">
                                <div class="row d-felx p-1">
                                    <div class="col-4 px-3" style="font-size:1.6rem;">
                                        <?php
                                        $title_time = strtotime($model->start_time);
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
                                <div class="" title="Subject"><?php echo $model->subject ?></div>
                                <div class="booking_info_label" title="Holder"><?php echo $model->getHolder() ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Time-display -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="rounded border overflow-hidden">
                            <div class="bg-white text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                <?php echo $model->getStartTime() . " - " . $model->getEndTime(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $form = \app\core\form\Form::begin('', 'post', 'Booking');
            echo $form->field($model, 'id')->hiddenField();
            echo new TextareaField($model, 'booker_note');
            echo \app\core\form\Form::end();
            ?>
        </div>

        <div class="row align-items-end">
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" form="Booking" value="book" class="btn btn-primary d-flex pe-1 <?= ($model->id == 0) ? 'disabled' : '' ?>">
                    <div>Save</div>
                    <iconify-icon class="d-flex align-items-center fs-4" icon="bx:chevron-right"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
</div>
