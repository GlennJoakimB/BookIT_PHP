<?php

namespace app\controllers
{
	use app\core\Controller;
    use app\core\Request;
	use app\models\RegisterModel;
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
		public function login()
        {
			$this->setLayout('auth');
            return $this->render('login');
        }

		public function register(Request $request)
        {
            $registerModel = new RegisterModel();
            if($request->isPost())
            {
				$registerModel->loadData($request->getBody());

				if($registerModel->validate() && $registerModel->register()){
                    return 'Success';
                }
                return $this->render('register',[
					'model' => $registerModel
				]);
            }
            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $registerModel
            ]);
        }
	}
}