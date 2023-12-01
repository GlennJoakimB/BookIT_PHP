<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
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
		public function __construct()
        {
			$ActionsRolemap = [];

			//All actions need you to be logged in, rolespesifik later.
            $this->registerMiddleware( new AuthMiddleware( [], $ActionsRolemap));
        }
	}
}