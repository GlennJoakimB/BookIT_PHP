<?php
/** @var $this \app\core\View */
$this->title = "admin";
?>
<h1>Administration</h1>

<!--Page intro-->
<div class="row">
    <p>On this page you can, create new courses and assign course holders</p>
</div>

<!--/.Page intro-->
<h3>Create a course</h3>

<!--Form-->
<?php $form = \app\core\form\Form::begin('', "post") ?>
<?php echo $form->field($model, 'name') ?>
<?php 
 //TODO: add a dropdown menu with possible course holders from search of users, input displayes the displayname of the user, but the value is the id of the user.
    //default value is the current user
 //echo $form->field($model, 'course_holder') 
?>
<?php echo $form->field($model, 'description') ?>
<?php echo $form->field($model, 'start_date')->dateField() ?>
<?php echo $form->field($model, 'end_date')->dateField() ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php echo \app\core\form\Form::end() ?>
<!--/.Form-->
