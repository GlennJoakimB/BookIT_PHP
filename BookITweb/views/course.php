<?php
use app\middlewares\AuthMiddleware;
    /**
     * @var $model \app\models\Course
     * @var $this \app\core\View
     */
    $this->title = 'Course';
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class=""><?= $model->name ?></h1>
            <div class="fs-5 mb-5"><?= $model->description ?></div>
            <div class="fs-5">Start date: <?= $model->start_date ?></div>
            <div class="fs-5 mb-5">End date: <?= $model->end_date ?></div>
            <div class="d-xl-inline-flex justify-content-sm-evenly">
                <div class="d-flex align-self-lg-start ">
                    <!--Hidden Form with button for joining the course-->
                    <form action="" method="post" id="joinCourseForm">
                        <input type="hidden" name="courseId" id="courseId" value="<?= $model->id ?>" />
                        <input type="hidden" name="userId" id="userId" value="<?= $userId ?>" />
                        <button type="submit" class="btn btn-primary"> Join Course</button>
                    </form>
                </div>
                <?php if (AuthMiddleware::isCourseOwner($model->id) || AuthMiddleware::isAdmin()): ?>
                <div class="d-flex ps-4 align-self-lg-start">
                    <a href="/courseAdmin?courseId=<?= $model->id ?>" class="btn btn-primary">
                        Manage Course
                    </a>
                </div>
                <?php endif ?>
            </div>
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <div class="fs-5 text-body-emphasis">Course Owner:</div>
                <div class="fs-5"><?= $model->getOwner()->firstname . ' ' . $model->getOwner()->lastname ?></div>
                <div class="fs-5 mt-4 text-body-emphasis">Email:</div>
                <div class="fs-5"><?=$model->getOwner()->email ?></div>
            </div>
        </div>
    </div>    
</div>
