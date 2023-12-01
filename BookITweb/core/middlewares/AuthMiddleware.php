<?php

namespace app\core\middlewares
{
	use app\core\Application;
    use app\core\middlewares\BaseMiddleware;
	use app\core\exeption\ForbiddenExeption;
    use app\core\UserModel;
	/**
	 * AuthMiddleware short summary.
	 *
	 * AuthMiddleware restricts access to pages based on the users role or if the user is logged in.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\middlewares
	 */
	class AuthMiddleware extends BaseMiddleware
	{
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

                    if($CurrentActionLvl=== UserModel::ROLE_ADMIN){
                        if($currentRole != UserModel::ROLE_ADMIN){
                            throw new ForbiddenExeption();
                        }
                    } elseif ($CurrentActionLvl === 'CourseOwner'){
                        // implement logic for course owner
                        if($currentRole != '' || $currentRole != UserModel::ROLE_ADMIN){
                            throw new ForbiddenExeption();
                        }

                    } elseif ($CurrentActionLvl === ''){
                        if($currentRole != 'LA' || $currentRole != 'CourseOwner'
                            || $currentRole != UserModel::ROLE_ADMIN)
                        {
                             throw new ForbiddenExeption();
                        }
                    } else{
                        throw new ForbiddenExeption();
                    }
                }
            }
        }

    }
}