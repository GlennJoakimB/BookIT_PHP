<?php

namespace app\controllers
{
	use app\core\Controller;
    use app\core\Request;
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
            if($request->isPost())
            {
                return "Handle submitted data";
            }
            $this->setLayout('auth');
            return $this->render('register');
        }
	}
}