<?php
use app\core\Application;
use app\core\UserModel;
/** @var $this \app\core\View */
$this->title = "Home";
?>

<h1>Home</h1>
<h3><?= $name ?></h3>


<div class="my-5">
    <!--Temp_list of courses:-->
    <div id="Topbar_courses" class="d-grid gap-2">

        <a class="btn btn-primary d-flex justify-content-between" href="/booking">
            Book new appointment
            <iconify-icon class="d-flex align-items-center fs-3" icon="bx:chevron-right"></iconify-icon>
        </a>
        <!-- Viewed if user_role == LA -->
        <?php if (!Application::isGuest() && (Application::isRole(UserModel::ROLE_TEACHER_ASSISTANT) || Application::isRole(UserModel::ROLE_ADMIN))): ?>
        <a class="btn btn-secondary d-flex justify-content-between" href="/booking/setup">
            <div>Set up new appointments</div>
            <iconify-icon class="d-flex align-items-center fs-3" icon="bx:chevron-right"></iconify-icon>
        </a>
        <?php else: ?>
        <a class="btn btn-secondary d-flex justify-content-between" href="/booking/setup">
            <div>Set up new appointments</div>
            <iconify-icon class="d-flex align-items-center fs-3" icon="bx:chevron-right"></iconify-icon>
        </a>
        <?php endif; ?>
    </div>
    <div class="list-group"></div>
</div>