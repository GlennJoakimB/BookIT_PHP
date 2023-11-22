<?php

namespace app\controllers
{
	use app\core\Controller;
    use app\core\Request;
	use app\models\User;
	use app\core\Application;
    use app\models\LoginForm;
    use app\core\Response;
	/**
	 * AuthController short summary.
	 *
	 * AuthController description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
	 */
	class AuthController extends Controller
	{
		public function login(Request $request, Response $response)
        {
            $loginForm = new LoginForm();
            if($request->isPost())
            {
                $loginForm->loadData($request->getBody());

                if($loginForm->validate() && $loginForm->login())
                {
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
            if($request->isPost())
            {
				$user->loadData($request->getBody());

				if($user->validate() && $user->save()){
					Application::$app->session->setFlash('success', 'Thanks for registering');
                    Application::$app->response->redirect('/');
                }
                return $this->render('register',[
					'model' => $user
				]);
            }
            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $user
            ]);
        }
	}
}