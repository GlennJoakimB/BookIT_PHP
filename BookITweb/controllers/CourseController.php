<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
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

		private function renderCourseAdmin($acitiveComp = 'editCourse')
        {
            $params = [
				'components' => [
                    'editCourse',
					'manageMembers'
					],
				'componentsParams' => [],
				'activeComponent' => $acitiveComp
				];
            return $this->render('courseAdmin', $params, true);
        }

		public function courseAdmin(Request $request)
        {
			if($request->isPost()){
                //if post, get body
				$body = $request->getBody();
				//check if body contains 'activeComponent'
				if(isset($body['activeComponent'])){
                    //if it does, set activeComponent to value
                    $activeComponent = $body['activeComponent'];
                }else{
                    //if not, set activeComponent to 'editCourse'
                    $activeComponent = 'editCourse';
                }
                return $this->renderCourseAdmin($activeComponent);
            }
            return $this->renderCourseAdmin();

        }
	}
}