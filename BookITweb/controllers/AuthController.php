<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\Request;
    use app\models\User;
    use app\core\Application;
    use app\models\LoginForm;
    use app\core\Response;
    use app\middlewares\AuthMiddleware;
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
            $actions = ['profile'];

            //no role restriction on actions
            $actionRoleAcsess = [];
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
	}
}