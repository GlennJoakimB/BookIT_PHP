<?php
use app\core\Application;
use app\core\UserModel;
/** @var $this \app\core\View */
$this->title = "Home";
?>

<h1>Home</h1>

<div class="mb-5">
    <?php if (!Application::isGuest()): ?>
    <h3><?= $name ?></h3>
    <div class="py-4">
        <a class="btn btn-primary p-4 d-flex justify-content-between" href="/dashboard">
            <div class="h1 mb-0">Go to Dashboard</div>
            <iconify-icon class="d-flex align-items-center h1  mb-0" icon="bx:chevron-right"></iconify-icon>
        </a>
    </div>
    <?php endif; ?>

    <!-- Active courses -->
    <div class="list-group">
        <div class="font_color_grey">
            <p>Courses to be added soon</p>
        </div>
    </div>
</div>