<?php

namespace app\core;

use \app\core\middlewares\BaseMiddleware;
/**
 * Class Controller
 *
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
class Controller
{

    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }
    public function render($view, $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
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
