<?php
/** @var $this \app\core\View */
$this->title = "Home";
?>

<h1>Home</h1>
<h3>Welcome <?= $name ?></h3>


<div class="my-5">
    Temp_list of available courses:
    <div id="Topbar_courses" class="">
        <div>
            <a href="/booking">Book</a>
        </div>
    </div>
    <div class="list-group"></div>
</div>