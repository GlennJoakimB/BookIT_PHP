<?php
use app\core\Application;
use app\core\UserModel;

/** @var $this \app\core\View */
$this->title = "Dashboard";
?>

<h1>Dashboard</h1>


<div class="my-4">
    <!--Temp_list of courses:-->
    <div id="Topbar_courses" class="d-grid gap-2">
        <a class="btn btn-primary d-flex justify-content-between" href="/booking">
            Book new appointment
            <iconify-icon class="d-flex align-items-center fs-3" icon="bx:chevron-right"></iconify-icon>
        </a>
        <?php if (Application::isTeacherAssistant() || Application::isRole(UserModel::ROLE_ADMIN)): ?>
            <a class="btn btn-outline-secondary d-flex justify-content-between" href="/booking/setup">
                <div>Set up new appointments</div>
                <iconify-icon class="d-flex align-items-center fs-3" icon="bx:chevron-right"></iconify-icon>
            </a>
        <?php endif; ?>
    </div>
    <div class="list-group">
        <?php if (empty($bookings)): ?>
            <div class="font_color_grey py-4">
                <p>Bookings to be added soon</p>
            </div>
        <?php else: ?>
            <div class="row py-4">


                <div class="col bg-white shadow-sm rounded py-2">

                    <h2>Your reserved bookings</h2>

                    <?php
                    if (!empty($bookings)):
                        foreach ($bookings as $course => $groups): ?>

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
                                                <div class="d-flex justify-content-between border-top">
                                                    <div class="bg-light_ text-center rounded-end p-1 border-end" style="min-width: 7rem;">
                                                        <?php echo $bookingSlot->getStartTime() . " - " . $bookingSlot->getEndTime(); ?>
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
        <?php endif; ?>

    </div>
</div>