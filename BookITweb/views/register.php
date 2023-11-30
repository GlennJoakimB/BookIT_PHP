<?php
/** @var $this \app\core\View */
$this->title = "Register";

/** @var $model \app\models\User */
?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="bg-white rounded shadow my-5">
            <div class="img rounded-top" style="height: 100px;background-color: aqua;">
                <div class="logo px-4 py-4" style="font-size: 2rem;">
                    <div>BookIT</div>
                    <iconify-icon icon="bx:book-bookmark"></iconify-icon>
                </div>
            </div>
            <div class="register-wrap p-4">
                <div class="d-flex">
                    <div class="w-100">
                        <h1 class="mb-4">Create an Account</h1>
                    </div>
                </div>
                <div id="form">
                    <?php $form = app\core\form\Form::begin('', "post") ?>
                    <?php echo $form->field($model, 'firstname') ?>
                    <?php echo $form->field($model, 'lastname') ?>
                    <?php echo $form->field($model, 'email') ?>
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                    <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
                    <?php echo app\core\form\Form::end() ?>
                </div>
                <div class="text-center mt-3">
                    Already have an account? <a href="/login">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>