<?php
/** @var $this \app\core\View */
$this->title = "Login";

/** @var $model \app\models\LoginForm */
?>


<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="bg-white rounded shadow my-5">
            <div class="img rounded-top d-flex p-4 fs-2 bg-primary-subtle">
                <div class="logo d-flex">
                    <div>BookIT</div>
                    <iconify-icon class="d-flex align-items-center fs-2" icon="bx:book-bookmark"></iconify-icon>
                </div>
            </div>
            <div class="login-wrap p-4">
                <div class="d-flex">
                    <div class="w-100">
                        <h1 class="mb-4">Login</h1>
                    </div>
                </div>
                <div id="form">
                    <?php $form = app\core\form\Form::begin('', "post") ?>
                    <?= $bannerError ?>
                    <?php echo $form->field($model, 'email') ?>
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Log in</button>
                    <?php echo app\core\form\Form::end() ?>
                </div>
                <div class="text-center mt-3">
                    Don't have an account? <a href="/register">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>