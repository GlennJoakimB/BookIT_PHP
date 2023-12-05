<?php
/** @var $this \app\core\View */
$this->title = "Course Administation";

?>

<!--Container with a sidebar nav and rightside content-->    
<div class="container bg-body-secondary rounded-5">
    <div class="sticky-top nav nav-tabs mb-3 bg-body-secondary rounded-top-5 ">        
        <!--hidden carry of corse id to post-->
        <div class="nav-item">
            <form method="post">
                <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                <button type="submit" name="activeComponent" value="editCourse" class="m-2 mb-1 nav-link
                <?php if($activeComponent === 'editCourse'){
                    echo 'active bg-body-secondary shadow'; } ?>">Edit Course</button>
            </form>
        </div>
        <div class="nav-item">
            <form method="post">
                <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                <button type="submit" name="activeComponent" value="manageMembers" class="m-2 mb-1 nav-link
                <?php if($activeComponent === 'manageMembers'){ 
                    echo 'active bg-body-secondary shadow';} ?>">Manage Members</button>
            </form>
        </div>
    </div>
    <!--Rightside content-->
    <div class="justify-content-center mb-4 p-2 pb-3">
        {{component.<?= $activeComponent?>}}
    </div>
</div>