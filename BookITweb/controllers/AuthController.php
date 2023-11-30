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
            $actions = ['profile', 'admin'];
            $this->registerMiddleware(new AuthMiddleware($actions, ['admin' => UserModel::ROLE_ADMIN]));
        }

        public function login(Request $request, Response $response)
        {
            $loginForm = new LoginForm();
            if ($request->isPost()) {
                $loginForm->loadData($request->getBody());

                if ($loginForm->validate() && $loginForm->login()) {
                    $response->redirect('/');

                    return;
                }
            }
            $this->setLayout('auth');
            return $this->render('login', [
                'model' => $loginForm
            ]);
        }

        public function logout(Request $request, Response $response)
        {
            Application::$app->logout();
            $response->redirect('/');
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
                return $this->render('register', [
                    'model' => $user
                ]);
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
        public function admin()
        {
            return $this->render('admin');
        }
    }
}