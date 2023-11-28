<?php
/** @var $this \app\core\View */
/** @var $model \app\models\CourseForm */
/** @var $courses \app\models\Course[] */
/** @var $course app\models\course */
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

<h3>Current courses</h3>

<!--Table-->
<?php if (!empty($courses)) : ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Course name</th>
            <th scope="col">Course holder</th>
            <th scope="col">Start date</th>
            <th scope="col">End date</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course) : ?>
        <?php /** @var $course app\models\course */
              $ownerName = $course->getOwner()->getDisplayName();
        ?>
            <tr>
                <td><?php echo $course->name ?></td>
                <td><?php echo $ownerName ?></td>
                <td><?php echo $course->start_date ?></td>
                <td><?php echo $course->end_date ?></td>
                <td><a href="/admin/edit?id=<?php echo $course->id ?>" class="btn btn-primary">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else : ?>
    <p>No courses found</p>
<?php endif; ?>