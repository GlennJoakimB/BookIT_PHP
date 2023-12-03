<?php
/** @var $this \app\core\View */
/** @var $model \app\models\Course */
/** @var $courses \app\models\Course[] */
/** @var $course app\models\course */
/** @var $isEdit bool*/
/** @var $potentialHolders \app\models\User[] */

//other then main post (Course form), The post body should be constructed like this:
// $postBody = [course => [$course], isEdit => (boool) $isEdit, search => (string) $search, uid =>  (int)$uid];
$course = $model->toString();

$this->title = "admin";
?>
<h1>Administration</h1>

<!--Page intro-->
<div class="row">
    <p>On this page you can, create new courses and assign course holders</p>
</div>

<!--/.Page intro-->
<?php if ($isEdit) : ?>
    <h3>Edit course:</h3>
    <a href="/admin" class="btn btn-primary">Create new course</a>
<?php else : ?>
    <h3>Create a new course:</h3>
<?php endif; ?>

<!--Form-->
<div class="row mb-5">
    <div class="col">
        <p>1. Search for course holder, if not selected you will be assinged</p>
        <div class="mb-3">
            <label>Enter name to search for: </label>
            <div class="input-group mb-3">
                <form action="/admin/search" method="post">
                    <input type="hidden" name="course" value="<?= $course ?>" />
                    <input type="hidden" name="isEdit" value="<?= serialize($isEdit) ?>" />
                    <input type="text" class="form-control"  name="search" value="<?= $searchValue ?>" aria-describedby="button-addon2" />
                    <input type="hidden" name="uid" value="<?= null; ?>" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary" id="button-addon2">Search</button>
                    </div>
                 </form>
            </div>
        </div>
        <p>Search results</p>
        <!-- TODO: Add display list of holders, with button to insert them into $model->owner_id-->
        <?php if (!empty($potentialHolders)) : ?>
            <table>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $showResultAmount;
                    $arrayLen = sizeof($potentialHolders);
                    $i = 0;
                    while ($i <= $showResultAmount && $i<$arrayLen) : 
                        $holder = $potentialHolders[$i];
                        ?>
                        <tr>
                            <td><?php echo $holder->getDisplayName() ?></td>
                            <!--TODO: Get to work on create to-->
                            <td>
                                <!--Hidden Form holding the post body variables-->
                                <form action="/admin/newHolder" method="post">
                                    <input type="hidden" name="course" value="<?= $course ?>" />
                                    <input type="hidden" name="isEdit" value="<?= serialize($isEdit) ?>" />
                                    <input type="hidden" name="search" value="<?= $searchValue ?>" />
                                    <input type="hidden" name="uid" value="<?= $holder->id ?>" />
                                    <button type="submit" class="m-lg-1 btn btn-primary" id="SetButton<?= $i?>">Set as course holder</button>
                                </form>
                            </td>
                        </tr>
                    <?php $i++; endwhile; ?>
            </table>
        <?php else : ?>
            <p>No results found</p>
        <?php endif; ?>
    </div>
    <!-- Left colum-->
    <div class="col">
        <p> 2. Fill out the form below to create a new course</p>
        <?php $form = \app\core\form\Form::begin('/admin', "post") ?>
        <?php echo $form->field($model, 'name') ?>
        <?php
        //Display dislpayname of $model->owner_id if it exists
        if (!empty($model->owner_id)) {
            $ownerName = $model->getOwner()->getDisplayName();
            echo "<p>Course holder: (Use the right search to change) </p>
                  <p> $ownerName</p>";
            
        }
        ?>
        <input type="hidden" name="owner_id" value="<?= $model->owner_id?>" />
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
        <!--/.Form-->
    </div>
</div>
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
                <td><a href="/admin/editcourse?id=<?= $course->id ?>" class="btn btn-primary">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else : ?>
    <p>No courses found</p>
<?php endif; ?>