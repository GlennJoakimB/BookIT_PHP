<?php 
    /** @var $this \app\core\View */
    $this->title = "Error";

    /** @var $exception \Exception */
?>
<h3><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage()?></h3>