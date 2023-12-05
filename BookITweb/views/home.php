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
            <a class="btn btn-outline-primary p-4 d-flex justify-content-between" href="/dashboard">
                <div class="h1 mb-0">Go to Dashboard</div>
                <iconify-icon class="d-flex align-items-center h1  mb-0" icon="bx:chevron-right"></iconify-icon>
            </a>
        </div>
    <?php endif; ?>

    <!-- Active courses -->
    <div class="pb-5">

        <?php
        if (!empty($activeCourse)): ?>

            <div> Current Active Courses
            </div>
            <div>
                <form class="d-flex gap-2" action="/" method="post">
                    <?php
                    foreach ($activeCourse as $course): ?>
                    <div class="w-50 bg-white shadow-sm rounded p-2">
                        <div class="d-flex flex-column">
                            <div class="fs-5"><?= $course->name ?></div>
                            <div class="mt-auto d-flex justify-content-end">
                                <?php if (array_key_exists($course->id, $memberships)): ?>
                                <button class="btn btn-outline-secondary disabled"> Joined
                                </button>
                                <?php else: ?>
                                <button class="btn btn-outline-primary" type="submit" name="submit" value="<?=$course->id?>"> Join
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    endforeach; ?>
                </form>
            </div>
        <?php else: ?>
            <div>
                <div class="font_color_grey">Courses to be added soon</div>
            </div>
        <?php endif; ?>

    </div>
</div>