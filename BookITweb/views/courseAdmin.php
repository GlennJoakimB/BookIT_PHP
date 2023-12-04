<?php
/** @var $this \app\core\View */
$this->title = "Course Administation";

?>

<!--Container with a sidebar nav and rightside content-->
<div class="container">
    <div class="row">
        <!--Sidebar nav-->
        <div class="col-3">
            <!--Buttons to switch active components through post-->
            <form method="post">
                <button type="submit" name="activeComponent" value="editCourse" class="btn btn-primary w-100 mb-2">Edit Course</button>
                <button type="submit" name="activeComponent" value="manageMembers" class="btn btn-primary w-100 mb-2">Manage Members</button>
            </form>
        </div>
        <!--Rightside content-->
        <div class="col-9">
            {{component.<?= $activeComponent?>}}
        </div>
    </div>
</div>
