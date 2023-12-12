<?php
use app\models\CourseMembership;

/** @var CourseMembership[] $courseMembers
* @var int $pagesAmount , total amount of pages
* @var int $currentPage , current page
* @var int $membersPerPage , amount of members per page
* @var bool $showAll , if true, show all members on one page
*/
//each page has a table of users, in the Table, the headers are
//UserDisplayname, is a ta, up or dowgrade ta, remove *currently disabled

//if showAll is true, no pagination is needed
if($showAll){
    $pagesAmount = 1;
    $currentPage = 1;
}

//Each type of post has a different post body, the body should be constructed like this:
//All Posts: include courseID in the body
// $postBody = [courseId => (int) $courseId];
//if the post is a page change, the body should be constructed like this:
// $postBody = [courseId => (int) $courseId, submit => (string)"changePage",
//                  page => (int) $page, membersPerPage => (int) $membersPerPage];
//if the post is a showAll, the body should be constructed like this:
// $postBody = [courseId => (int) $courseId, submit => (string)"showAll", showAll => (bool) $showall];
// and simmilar for the other posts



?>

<h3>Manage your course members</h3>

<div class="container">
<!---->
<?php if($showAll || $pagesAmount <= 1): ?>
<!--Diplay for showing all-->
    <div>
        <p>Showing all Members:</p>
    </div>
<?php else: ?>
<!--Display for pagination-->
    <div class="pagination">
        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
            <input type="hidden" name="submit" value="changePage" />
            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
            <input type="hidden" name="page" value="<?= $currentPage - 1 ?>" />
            <button type="submit" class="btn btn-primary page-link <?= $currentPage == 1 ? 'disabled' : '' ?>" <?= $currentPage == 1 ? 'disabled' : '' ?> aria-label="previous">
                <span aria-hidden="true">&laquo;</span>
            </button>
        </form>
        <!--Show up to five page buttons first is firstpage, fith is lastpage. The three in the middle are:
            second one down from current, third current, fourth next from current.
            if page is less then five show all-->
        <?php if($pagesAmount <= 5): ?>
            <?php for($i = 1; $i <= $pagesAmount; $i++): ?>
                <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                    <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                    <input type="hidden" name="submit" value="changePage" />
                    <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                    <input type="hidden" name="page" value="<?= $i ?>" />
                    <button type="submit" class="btn btn-primary page-link <?= $currentPage == $i ? 'active' : '' ?>" <?= $currentPage == $i ? 'disabled' : '' ?>><?= $i ?></button>
                </form>
            <?php endfor ?>
        <?php else: ?>
            <?php if($currentPage == 1): ?>
                <!--if current page is first, show first five, fifth show last page-->
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($i == 5): ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= $pagesAmount ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == $pagesAmount ? 'Active' : '' ?>" <?= $currentPage == $pagesAmount ? 'disabled' : '' ?>><?= $pagesAmount ?></button>
                        </form>
                    <?php else: ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= $i ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == $i ? 'active' : '' ?>" <?= $currentPage == $i ? 'disabled' : '' ?>><?= $i ?></button>
                        </form>
                    <?php endif ?>
                <?php endfor ?>
            <?php elseif($currentPage == $pagesAmount): ?>
                <!--if current page is last, show last four, first is first page-->
                <?php for($i = 1; $i <= 5; $i++):?>
                        <?php if($i == 1): ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= 1 ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == 1 ? 'active' : '' ?>" <?= $currentPage == 1 ? 'disabled' : '' ?>><?= 1 ?></button>
                        </form>
                    <?php else: ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= $pagesAmount - (5 - $i) ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == $pagesAmount - (5 - $i) ? 'active' : '' ?>" <?= $currentPage == $pagesAmount - (5 - $i) ? 'disabled' : '' ?>><?= $pagesAmount - (5 - $i) ?></button>
                        </form>
                    <?php endif ?>
                <?php endfor ?>
            <?php else: ?>
                <!--if current page is in the middle, show five, First is first page, fifth is last page-->
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($i == 1): ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= 1 ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == 1 ? 'active' : '' ?>" <?= $currentPage == 1 ? 'disabled' : '' ?>><?= 1 ?></button>
                        </form>
                <?php elseif($i == 5): ?>
                    <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= $pagesAmount ?>" />
                        <button type="submit" class="btn btn-primary page-link <?= $currentPage == $pagesAmount ? 'active' : '' ?>" <?= $currentPage == $pagesAmount ? 'disabled' : '' ?>><?= $pagesAmount ?></button>
                        </form>
                    <?php else: ?>
                        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
                            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                            <input type="hidden" name="submit" value="changePage" />
                            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                            <input type="hidden" name="page" value="<?= $currentPage - (3 - $i) ?>" />
                            <button type="submit" class="btn btn-primary page-link <?= $currentPage == $currentPage - (3 - $i) ? 'active' : '' ?>" <?= $currentPage == $currentPage - (3 - $i) ? 'disabled' : '' ?>><?= $currentPage - (3 - $i) ?></button>
                        </form>
                    <?php endif ?>
                <?php endfor ?>
            <?php endif ?>
        <?php endif ?>
        <form action="/courseAdmin/manageMembers" method="post" class="page-item">
            <input type="hidden" name="courseId" value="<?= $courseId ?>" />
            <input type="hidden" name="submit" value="changePage" />
            <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
            <input type="hidden" name="page" value="<?= $currentPage + 1 ?>" />
            <button type="submit" class="btn btn-primary page-link <?= $currentPage == $pagesAmount ? 'disabled' : '' ?>" 
                <?= $currentPage == $pagesAmount ? 'disabled' : '' ?> aria-label="next">
                <span aria-hidden="true">&raquo;</span>
            </button>
        </form>
    </div>
<?php endif ?>
    <!--Displaing the table if members empty, show message-->
    <div>
        <?php if(empty($courseMembers)): ?>
            <p>There are no members in this course</p>
        <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <div class="card-text">
                            <?php 
                                if($courseMembers == 1){
                                    echo 'There is 1 member in this course';
                                }else{
                                    echo 'There are ' .
                                        count($courseMembers) .
                                        ' members in this course';
                                }
                            ?>
                            </div>
                            <!--Button for modal-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeDisplayAmount">
                                Change Display Amount
                            </button>
                         </div>
                    </div>
                <!--Modal-->
                <div class="modal" id="changeDisplayAmount" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Change Display Amount</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/courseAdmin/manageMembers" method="post" id="changeMembersPerPage">
                                    <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                                    <input type="number" name="membersPerPage" value="<?= $membersPerPage ?>" />
                                </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" value="changeShowcount" form="changeMembersPerPage" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End of modal-->

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Teaching Assistant</th>
                        <th>Up/Downgrade</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($courseMembers as $member): ?>
                        <tr>
                            <td>
                                <?php 
                                    $name = $member->userDisplayName;
                                    if(empty($member->userDisplayName)){
                                            $name = 'not available';
                                    };
                                    echo $name; 
                                    ?>
                            </td>
                            <td><?php echo $member->teachingAssistant ? 'Yes' : 'No' ?></td>
                            <td>
                                <form action="/courseAdmin/manageMembers" method="post">
                                    <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                                    <input type="hidden" name="page" value="<?= $currentPage?>"/>
                                    <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                                    <input type="hidden" name="submit" value="updateTAStatus" />
                                    <input type="hidden" name="uid" value="<?= $member->user_id ?>" />
                                    <input type="hidden" name="isTa" value="<?= $member->teachingAssistant ? 'false' : 'true' ?>" />
                                    <button type="submit" class="btn btn-primary page-link">Change</button>
                                </form>
                            </td>
                            <td>
                                <form action="/courseAdmin/manageMembers" method="post">
                                    <input type="hidden" name="courseId" value="<?= $courseId ?>" />
                                    <input type="hidden" name="membersPerPage" value="<?= $membersPerPage ?>" />
                                    <input type="hidden" name="submit" value="remove" />
                                    <input type="hidden" name="uid" value="<?= $member->user_id ?>" />
                                    <button type="submit" class="btn btn-primary page-link disabled" disabled>Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>
      
