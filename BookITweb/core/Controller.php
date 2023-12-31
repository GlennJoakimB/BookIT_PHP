<?php

namespace app\core;

use \app\core\middlewares\BaseMiddleware;
/**
 * Class Controller
 * 
 * Controller is abstarct class used for types in the core, and is the base of each controller.
 *
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
class Controller
{

    public string $layout = 'main';
    public string $action = '';

    /**
     * @var BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }
    
    /**
     * Render the view with given paramaters
     * 
     * @param mixed $view 
     * @param mixed $params 
     * @return array|string
     */
    public function render($view, $params = [], $withComponents = false): string
    {
        return Application::$app->view->renderView($view, $params, $withComponents);
    }

    /**
     * Register middleware
     * 
     * @param \app\core\BaseMiddleware $middleware
     */
    public function registerMiddleware(BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;
    }

    /**
     * Get all middlewares
     *
     * @return \app\core\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
