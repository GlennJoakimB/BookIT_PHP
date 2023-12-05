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
        <div class="font_color_grey py-4">
            <p>Bookings to be added soon</p>
        </div>

    </div>
</div>