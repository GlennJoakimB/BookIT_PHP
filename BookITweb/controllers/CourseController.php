<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\exeption\ForbiddenExeption;
    use app\core\exeption\NotFoundExeption;
    use app\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\UserModel;
    use app\models\Course;
    use app\models\CourseMembership;
    use app\helpers\CoursesHelper;

	/**
	 * CourseController short summary.
	 *
	 * CourseController manage actions releted to in course managment
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
	 */
	class CourseController extends Controller
	{
        public int $courseID = 0;
        protected Course $course;

        protected array $members;
		public function __construct()
        {
			$ActionsRolemap = [
                'courseAdmin' => AuthMiddleware::ROLE_COURSEOWNER,
                'postEditCourse' => AuthMiddleware::ROLE_COURSEOWNER,
                'manageMembers' => AuthMiddleware::ROLE_COURSEOWNER

                ];

			//All actions need you to be logged in, rolespesifik later.
            $this->registerMiddleware( new AuthMiddleware( [], $ActionsRolemap));
        }
        private function renderCourse(){
            /** @var \app\models\User $user */
            $user = Application::$app->user;
            if(!isset($this->course) && isset($this->courseId)){
                $this->loadCourseFromDb($this->courseId);
            } elseif(!isset($this->course)) {
                Application::$app->response->redirect('/');
            }

            $activeCourse = $this->course;
            $params = [
               'model' => $activeCourse,
               'courseId' => $activeCourse->id,
               'userId' => $user->id
                ];
            return $this->render('course', $params);
        }
		private function renderCourseAdmin(
            $acitiveComp = 'editCourse',
            $showAll= false,
            $activePage = 1,
            $membersPerPage = 10
            )
        {
            $shownCourseMembers = [];
            if (!isset($this->course)) {
                //try get course from db if not set
                if(!isset($this->courseID)){
                    throw new NotFoundExeption();
                }
                $this->loadCourseFromDb($this->courseID);
            }

            $pages = 1;
            if($acitiveComp == 'manageMembers'){
                //if activeComponent is manageMembers, load members with helper
                $members = CoursesHelper::getCourseMembers($this->courseID);
                $this->members = $members;
                //if showAll is true, show all members
                if($showAll){
                    $shownCourseMembers = $members;
                }else{
                    //use helper to get members for page
                    $shownCourseMembers = CoursesHelper::getCourseMembersSubset(
                        $this->courseID, $activePage, $membersPerPage, $members);
                    //calculate pages
                    $pages = ceil(count($members) / $membersPerPage);
                }
            }
            $membersTot = 0;
            if(isset($this->members)){
                $membersTot = count($this->members);
            }

            $componentParams = [
                    'model' => $this->course,
                    'courseId' => $this->course->id,
                    'courseMembers' => $shownCourseMembers,
                    'pagesAmount' => $pages,
                    'currentPage' => $activePage,
                    'membersPerPage' => $membersPerPage,
                    'showAll' => $showAll,
                    'membersTotal' => $membersTot
                ];

            $params = [
				'components' => [
                    'editCourse',
					'manageMembers'
					],
				'componentsParams' => $componentParams,
				'activeComponent' => $acitiveComp,
                'courseId' => $this->course->id
				];
            return $this->render('courseAdmin', $params, true);
        }

        public function course(Request $request){
            if ($request->isGet()) {
                //get courseID from request
                if (!isset($request->getQueryParams()['courseId'])) {
                    throw new NotFoundExeption();
                }
                $courseID = $request->getQueryParams()['courseId'];
                try {
                    $this->loadCourseFromDb($courseID);
                } catch (\Exception $e) {
                    throw new NotFoundExeption();
                }
                $this->courseID = $courseID;
            } elseif($request->isPost()) {
                $courseMember = new CourseMembership();
                //manualy load data from body
                $body = $request->getBody();
                $courseMember->course_id = $body['courseId'];
                $courseMember->user_id = $body['userId'];
                $courseMember->teachingAssistant = false;

                //check if user is already member
                $dbReturn = CourseMembership::findOne(['course_id' => $body['courseId'], 'user_id' => $body['userId']]);
                if($dbReturn !== false){
                    Application::$app->session->setFlash('error', 'You are already a member of this course');
                    return $this->renderCourse();
                }
                //try to save

                if (!$courseMember->save()) {
                    Application::$app->session->setFlash('error', 'Something went wrong when attempting to save new course.');
                    return $this->renderCourse();
                } else {
                    Application::$app->session->setFlash('success', 'You are now a member of this course');
                }
                $this->loadCourseFromDb($body['courseId']);
                $this->courseID = $body['courseId'];
            }
            return $this->renderCourse();
        }

		public function courseAdmin(Request $request)
        {
            if ($request->isGet()) {
                //get courseID from request
                if(!isset($request->getQueryParams()['courseId']))
                {
                    throw new NotFoundExeption();
                }
                $courseID = $request->getQueryParams()['courseId'];
                $this->loadCourseFromDb($courseID);
            }

			if($request->isPost()){
                //if post, get body
				$body = $request->getBody();
				//check if body contains 'activeComponent'
				if(isset($body['activeComponent']) && isset($body['courseId'])){
                    //if it does, set activeComponent to value
                    $activeComponent = $body['activeComponent'];
                    $this->courseID = $body['courseId'];
                }else{
                    //if not, set activeComponent to 'editCourse'
                    $activeComponent = 'editCourse';
                }
                //if activeComponent is manageMembers, load members with helper
                if($activeComponent == 'manageMembers'){
                    $members = CoursesHelper::getCourseMembers($this->courseID);
                    $this->members = $members;
                }
                return $this->renderCourseAdmin($activeComponent);
            }
            return $this->renderCourseAdmin();

        }
        private function loadCourseFromDb($courseID)
        {
            $course = Course::findOne(['id' => $courseID]);
            if ($course === false) {
                throw new NotFoundExeption();
            }
            $this->course = $course;
        }

        public function postEditCourse(Request $request)
        {
            //get body from request
            $body = $request->getBody();
            //get course from db
            $this->loadCourseFromDb($body['id']);
            $this->courseID = $body['id'];
            //get user from app
            /** @var \app\models\user $user */
            $user = Application::$app->user;

            //compare owner_id with user_id or role == admin
            if($this->course->owner_id != $user->id && !Application::isRole(UserModel::ROLE_ADMIN)){
                throw new ForbiddenExeption;
            }
            //compare if changes was made
            if($this->course->name == $body['name'] && $this->course->description == $body['description']){
                Application::$app->session->setFlash('error', 'No changes was made.');
                return $this->renderCourseAdmin('editCourse');
            }

            //load data from body
            $this->course->loadData($body);
            //validate
            if (!$this->course->validate()) {
                Application::$app->session->setFlash('error', 'Some input was not valid.');
                return $this->renderCourseAdmin('editCourse');
            }
            //try to save
            if (!$this->course->update()) {
                Application::$app->session->setFlash('error', 'Something went wrong when attempting to save new course.');
                return $this->renderCourseAdmin('editCourse');
            }
            //if no error, succsess
            Application::$app->session->setFlash('success', 'Course updated.');
            return $this->renderCourseAdmin('editCourse');
        }

        public function manageMembers(Request $request){

            if ($request->isGet()) {
                //run default action
                return $this->courseAdmin($request);
            }
            //get post type from body key 'submit'
            $postType = $request->getBody()['submit'];

            //setting default values for the params
            $component = 'manageMembers';
            $showAll = false;
            $activePage = 1;
            $memberPerPage = 10;
            //set courseID
            $this->courseID = $request->getBody()['courseId'];

            //switch on post type
            switch ($postType) {
                case 'removeMember':
                    //send to helper to remove member
                    //TODO: add removing logic
                    //get showcou from body
                    $showAll = $request->getBody()['memberPerPage'];
                    break;
                case 'showAll':
                    $showAll = $request->getBody()['showAll'];
                    break;
                case 'updateTAStatus':
                    //load user from db
                    try{
                        $user = \app\models\User::findOne(['id' => $request->getBody()['uid']]);
                        //find courseMembership
                        $courseMembership = CourseMembership::findOne([
                            'course_id' => $this->courseID,
                            'user_id' => $user->id
                            ]);
                        //if not found, throw error
                        if($courseMembership === false){
                            throw new \Exception('CourseMembership not found');
                        }
                        //update teachingAssistant status
                        $response = $request->getBody()['isTa'];
                        if($response == 'true'){
                            $courseMembership->teachingAssistant = true;
                        }else {
                            $courseMembership->teachingAssistant = false;
                        }
                        //save
                        $courseMembership->update();

                    }catch (\Exception $e){
                        Application::$app->session->setFlash('error',
                            'Something went wrong when attempting to update TA status.');
                    }
                    break;
                case 'changePage':
                    $activePage = $request->getBody()['page'];
                    //continue to changeShowcount
                case 'changeShowcount':
                    $memberPerPage = $request->getBody()['membersPerPage'];
                    break;
                default:
                    echo '<pre>';
                    var_dump($request->getBody());
                    echo '</pre>';
                    exit;
            }

            //do rendering with new params
            return $this->renderCourseAdmin($component, $showAll, $activePage, $memberPerPage);
        }
	}
}