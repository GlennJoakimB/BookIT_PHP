<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\exeption\NotFoundExeption;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\models\Course;

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
				'componentsParams' => ['model' => $this->course],
				'activeComponent' => $acitiveComp
				];
            return $this->render('courseAdmin', $params, true);
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
        private function loadCourseFromDb($courseID)
        {
            $course = Course::findOne(['id' => $courseID]);
            if ($course === false) {
                throw new NotFoundExeption();
            }
            $this->course = $course;
        }
	}
}