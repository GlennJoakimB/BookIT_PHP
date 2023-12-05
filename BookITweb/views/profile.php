<?php
    /** @var $this \app\core\View */
    /** @var $model \app\models\User */
    $model->password = '';
    $this->title = "Profile";
?>
<div class="container bg-body-secondary p-4">
    <div class="">
        <h3 class="text-center">Profile:</h3>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Setting</th>
                    <th scope="col">Your settings</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <td scope="col">Firstname:</td>
                    <td scope="col"><?= $model->firstname ?></td>
                </tr>
                <tr>
                    <td scope="col">Lastname:</td>
                    <td scope="col"><?= $model->lastname ?></td>
                </tr>
                <tr>
                    <td scope="col">Email:</td>
                    <td scope="col"><?= $model->email ?></td>
                </tr>
            </tbody>
        </table><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Edit Profile
        </button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php $form = \app\core\form\Form::begin('', "post", 'updateUser') ?>
                        <div class="row">
                            <div class="col">
                                <?php echo $form->field($model, 'firstname') ?>
                            </div>
                            <div class="col">
                                <?php echo $form->field($model, 'lastname') ?>
                            </div>
                        </div>
                        <?php echo $form->field($model, 'email') ?>
                        <?php echo $form->field($model, 'password')->passwordField() ?>
                        <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
                        <?php \app\core\form\Form::end() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="updateUser" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>