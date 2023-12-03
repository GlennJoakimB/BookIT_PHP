<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\Request;
    use app\models\User;
    use app\core\Application;
    use app\models\LoginForm;
    use app\core\Response;
    use app\core\middlewares\AuthMiddleware;
    use app\core\UserModel;
    use app\models\Course;

    /**
     * AuthController short summary.
     *
     * AuthController Handels restricted pages and the authentication of users pages.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
     */
    class AuthController extends Controller
    {
        public function __construct()
        {
            //conifgure the middleware
            $actions = ['profile', 'admin', 'editCourse'];
            $actionRoleAcsess = [
                'admin' => UserModel::ROLE_ADMIN,
                'editCourse' => UserModel::ROLE_ADMIN
            ];
            $this->registerMiddleware(new AuthMiddleware($actions, $actionRoleAcsess));
        }


        /**
         * Method for handeling login logic.
         *
         * @param Request $request
         * @param Response $response
         * @return array|string
         */
        public function login(Request $request, Response $response)
        {
            $loginForm = new LoginForm();
            $bannerError = '';
            if ($request->isPost()) {
                $loginForm->loadData($request->getBody());

                if ($loginForm->validate() && $loginForm->login()) {
                    $response->redirect('/');

                    return;
                }

                //retrieve banner error if any
                $bannerError = $loginForm->bannerError;
            }
            $this->setLayout('auth');
            return $this->render('login', [
                'model' => $loginForm,
                'bannerError' => $bannerError
            ]);
        }

        public function logout(Request $request, Response $response)
        {
            Application::$app->logout();
            $response->redirect('/login');
        }

        public function register(Request $request)
        {
            $user = new User();
            if ($request->isPost()) {
                $user->loadData($request->getBody());

                if ($user->validate() && $user->save()) {
                    Application::$app->session->setFlash('success', 'Thanks for registering');
                    Application::$app->response->redirect('/');
                }
                //return $this->render('register', [
                //    'model' => $user
                //]);
            }
            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $user
            ]);
        }

        //render the profile view
        public function profile()
        {
            return $this->render('profile');
        }

        //render the admin view
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
            /** @var user app\models\user */
            $course->owner_id = Application::$app->user->id;
            if ($request->isPost()) {
                $course->loadData($request->getBody());
                if ($course->validate() && $course->Save()) {
                    Application::$app->session->setFlash('success', 'Course added');
                    Application::$app->response->redirect('/admin');
                }
                return $this->adminRender($course, $courses);
            }
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

            $UriParams = $request->getUriParams();
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
            $course->loadData(explode('&', $body['course']));
            $oldOwnerId = $course->owner_id;
            $course->owner_id = $body['uid'];
            $courses = Course::findAll();
            if ($course->validate()) {
                Application::$app->session->setFlash('success', 'New holder set!');
                return $this->adminRender($course, $courses, $isEdit, [], $body['search']);
            } else {
                //if validation fails, set owner_id back to old value and set flash message
                Application::$app->session->setFlash('error', 'New holder could not be set');
                $course->owner_id = $oldOwnerId;
            }
            return $this->adminRender($course, $courses, (bool) $isEdit);
        }

        public function postSearch(Request $request)
        {
            //if get request, redirect to admin
            if ($request->isGet()) {
                $this->admin($request);
            }

            $search = $request->getBody()['search'];
            $isEdit = unserialize($request->getBody()['isEdit']);
            $course = new course();

            $course->loadData(explode('&', ($request->getBody()['course'])));
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