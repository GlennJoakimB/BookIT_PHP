<?php
/** @var $this \app\core\View */
$this->title = "Login";

/** @var $model \app\models\LoginForm */
?>


<h1>Login</h1>

<?php $form = app\core\form\Form::begin('', "post") ?>
<?= $bannerError ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordField() ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php echo app\core\form\Form::end() ?>