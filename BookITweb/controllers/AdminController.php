<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\Request;
    use app\middlewares\AuthMiddleware;
    use app\models\User;
    use app\core\Application;
    use app\core\Response;
    use app\core\UserModel;
    use app\models\Course;
	/**
	 * AdminController short summary.
	 *
	 * AdminController manages all admin path and actions
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
	 */
	class AdminController extends Controller
	{
        public function __construct()
        {
            //conifgure the middleware
            $actions = [ 'admin', 'editCourse', 'postSetNewHolder', 'postSearch'];
            $actionRoleAcsess = [
                'admin' => UserModel::ROLE_ADMIN,
                'editCourse' => UserModel::ROLE_ADMIN,
                'postSetNewHolder' => UserModel::ROLE_ADMIN,
                'postSearch' => UserModel::ROLE_ADMIN
            ];
            $this->registerMiddleware(new AuthMiddleware($actions, $actionRoleAcsess));
        }

        public function admin(Request $request)
        {
            $course = new Course();
            $courses = Course::findAll();
            if (!($courses === [])) {
                $courses = array_reverse($courses);
                //loop through courses and run getOwner() on each
                foreach ($courses as $key => $value) {
                    $courses[$key]->owner = $value->getOwner();
                }
            }

            if ($request->isPost()) {
                $course->loadData($request->getBody());
                if ($course->validate() && $course->Save()) {
                    Application::$app->session->setFlash('success', 'Course added');
                    Application::$app->response->redirect('/admin');
                }
                return $this->adminRender($course, $courses);
            }
            /** @var user app\models\user */
            $course->owner_id = Application::$app->user->id;
            return $this->adminRender($course, $courses);
        }

        /**
         * @param Course $course
         * @param Course[] $courses
         * @param bool $isEdit
         * @param User[] $potentialHolders
         * @param string $search
         */
        private function adminRender(
            Course $course,
            $courses = [],
            bool $isEdit = false,
            $potentialHolders = [],
            $search = ''
        ) {


            if (!is_object($course)) {
                $course = new Course();
            }
            if ($course->owner_id === null) {
                $course->owner_id = Application::$app->user->id;
            }
            //if input values empty makes them default
            if (!isset($courses)) {
                $courses = [];
            }
            if (!isset($isEdit)) {
                $isEdit = false;
            }
            if (!isset($potentialHolders)) {
                $potentialHolders = [];
            }
            if (!isset($search)) {
                $search = '';
            }

            return $this->render('admin', [
                'model' => $course,
                'courses' => $courses,
                'isEdit' => $isEdit,
                'potentialHolders' => $potentialHolders,
                'searchValue' => $search,
                'showResultAmount' => 5,
            ]);
        }

        public function editCourse(Request $request)
        {

            $UriParams = $request->getQueryParams();
            $CourseId = $UriParams['id'];
            $isEdit = true;
            $course = Course::findOne(['id' => $CourseId]);

            $courses = Course::findAll();
            if ($course === false) {
                Application::$app->session->setFlash('error', 'Course not found');
                Application::$app->response->redirect('/admin');
            }
            if ($request->isPost()) {
                $course->loadData($request->getBody());
                if ($course->validate() && $course->Update()) {
                    Application::$app->session->setFlash('success', 'Course updated');
                    Application::$app->response->redirect('/admin');
                }
                return $this->adminRender($course, $courses, $isEdit);
            }
            return $this->adminRender($course, $courses, $isEdit);
        }

        public function postSetNewHolder(Request $request)
        {
            //if get request, redirect to admin
            if ($request->isGet()) {
                $this->admin($request);
            }
            $body = $request->getBody();
            $isEdit = $body['isEdit'];

            $course = new Course();
            $course->loadData($course->fromString($body['course']));

            $course->owner_id = (int) $body['uid'];

            $courses = Course::findAll();
            Application::$app->session->setFlash('success', 'New holder set!');

            return $this->adminRender($course, $courses, (bool) $isEdit);
        }

        public function postSearch(Request $request)
        {
            //if get request, redirect to admin
            if ($request->isGet()) {
                $this->admin($request);
            }
            $body = $request->getBody();

            $search = $body['search'];
            $isEdit = unserialize($body['isEdit']);
            $course = new course();

            $course->loadData($course->fromString($body['course']));

            $courses = Course::findAll();

            //run search of users, mathing the search string on db
            /** @var $users app\models\User[] */
            $users = User::SearchForValues(['firstname' => $search, 'lastname' => $search]);

            //loop through courses and run getOwner() on each
            foreach ($courses as $key => $value) {
                $courses[$key]->owner = $value->getOwner();
            }
            return $this->adminRender($course, $courses, $isEdit, $users, $search);



        }
	}
}