<?php
/** var @model app\models\Course */

?>

<h3 class="text-center">Current course details:</h3>

<!--A table representing the current course information
    First column is the name of the field
    Second column is the current value of the field
    -->
<div class="container">
    <table class="table table-striped table object-fit-contain align-content-center">
        <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Current value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Course name</td>
                <td><?php echo $model->name ?></td>
            </tr>
            <tr>
                <td>Course holder</td>
                <td><?php echo $model->getOwner()->getDisplayName() ?></td>
            </tr>
            <tr>
                <td>Course description</td>
                <td><?php echo $model->description ?></td>
            </tr>
            <tr>
                <td>Start date</td>
                <td><?php echo $model->start_date ?></td>
            </tr>
            <tr>
                <td>End date</td>
                <td><?php echo $model->end_date ?></td>
            </tr>
        </tbody>
    </table>
</div>
<!--Ifomation on changing the values-->
<div class="">
    <p class="card p-3">Below you can edit the information about the course, But if you should want to transfere
    ownsership of course ask a site Admin. </p>
</div>
<div class="bg-opacity-50 bg-body-tertiary rounded-5 p-4">
    <h3 class="justify-content-center">Edit the fields you want to update and submit:</h3>
    <!--Form-->
    <?php $form = \app\core\form\Form::begin('/courseAdmin/editCourse', "post") ?>
    <?php echo $form->field($model, 'id')->hiddenField() ?>
    <?php echo $form->field($model, 'owner_id')->hiddenField() ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'description') ?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'start_date')->dateField() ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'end_date')->dateField() ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php echo \app\core\form\Form::end() ?>
</div>