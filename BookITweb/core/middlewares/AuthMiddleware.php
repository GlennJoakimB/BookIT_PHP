<?php

namespace app\core\middlewares
{
	use app\core\Application;
    use app\core\middlewares\BaseMiddleware;
	use app\core\exeption\ForbiddenExeption;
	/**
	 * AuthMiddleware short summary.
	 *
	 * AuthMiddleware description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\middlewares
	 */
	class AuthMiddleware extends BaseMiddleware
	{
		public array $actions = [];
        
        public function __construct(array $actions = [])
        {
            $this->actions = $actions;
        }

		public function execute()
        {
			if(Application::isGuest()){
                if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
                {
                    throw new ForbiddenExeption();
                }
            }    
        }
        
	}
}