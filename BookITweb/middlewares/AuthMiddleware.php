<?php

namespace app\middlewares
{
    use app\core\Application;
    use app\core\exeption\ForbiddenExeption;
    use app\core\middlewares\BaseMiddleware;
    use app\core\UserModel;
	/**
	 * AuthMiddleware short summary.
	 *
	 * AuthMiddleware description.
	 *
	 * @version 1.0
	 * @author Tom
	 */
	class AuthMiddleware extends BaseMiddleware
	{
        //public Consts for Auth lvl
        public const ROLE_ADMIN = 'admin';
        public const ROLE_COURSEOWNER = 'CourseOwner';
        public const ROLE_TA = 'TA';

		public array $actions = [];
		//array Actions => Role
		public array $roleActionMap = [];


        public function __construct(array $actions = [], array $roleActionMap = [])
        {
            $this->actions = $actions;
			$this->roleActionMap = $roleActionMap;
        }

		public function execute()
        {
            $request = Application::$app->request;
			if(Application::isGuest()){
                if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
                {
                    throw new ForbiddenExeption();
                }
            }
			//if roleActionMap is not empty, check if the user is allowed to access the action
            if (!empty($this->roleActionMap)) {
                $currentAction = Application::$app->controller->action;
                $currentRole = Application::$app->user->role ?? null;
                if (array_key_exists($currentAction, $this->roleActionMap)) {
                    //gets min auth lvl
                    $CurrentActionLvl = $this->roleActionMap[$currentAction];
                    $courseId = 0;
                    //get course id if it exists
                    /** @var $request app\core Request*/
                    if ($request->isGet()) {
                        $courseId = $request->getQueryParams()['courseId'];
                    } else {
                        $courseId = $request->getBody()['courseId'] ?? 0;
                    }
                    if($CurrentActionLvl=== self::ROLE_ADMIN){
                        if($currentRole != UserModel::ROLE_ADMIN){
                            throw new ForbiddenExeption();
                        }
                    } elseif ($CurrentActionLvl === self::ROLE_COURSEOWNER){
                        // implement logic for course owner
                        if(!$this->isCourseOwner($courseId) && $currentRole != UserModel::ROLE_ADMIN){
                            throw new ForbiddenExeption();
                        }

                    } elseif ($CurrentActionLvl === self::ROLE_TA){
                        if(!$this->isTeacherAssistant($courseId) && !$this->isCourseOwner($courseId)
                            && $currentRole != UserModel::ROLE_ADMIN)
                        {
                             throw new ForbiddenExeption();
                        }
                    } else{
                        throw new ForbiddenExeption();
                    }
                }
            }
        }

        private function isCourseOwner(int $courseId): bool
        {
            $UserCourseOwnerships = Application::$app->user->getRelatedObject('courseOwnerships');
            foreach ($UserCourseOwnerships as $UserCourseOwnership) {
                if ($UserCourseOwnership->course_id == $courseId) {
                    return true;
                }
            }
            return false;
        }

        private function isTeacherAssistant(int $courseId): bool
        {
            $UserTACourses = [];
            $UserCourses = Application::$app->user->getRelatedObject('courseMemberships');
            //loop through courses and get TA courses
            foreach ($UserCourses as $UserCourse) {
                if ($UserCourse->teachingAssistant == 1) {
                    $UserTACourses[] = $UserCourse;
                }
            }
            if(empty($UserTACourses)){
                return false;
            }
            //loop through TA courses and check if courseID matches
            foreach ($UserTACourses as $UserTACourse) {
                if ($UserTACourse->course_id == $courseId) {
                    return true;
                }
            }
            return false;
        }
	}
}