<?php

namespace app\core;

/**
 * Application
 *
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Database $db;


    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

       $this->db = new Database($config['db']);
    }

    /**
     * Set the controller
     *
     * @param \app\core\Controller $controller
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get the controller
     *
     * @return \app\core\Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    public function run()
    {
       echo $this->router->resolve();
    }
}
