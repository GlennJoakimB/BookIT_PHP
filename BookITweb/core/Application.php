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
    public static Application $app;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public Database $db;
    public ?DbModel $user;


    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

       $this->db = new Database($config['db']);

       $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
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
        try {
            echo $this->router->resolve();
        }catch(\Exception $e)
        {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView('error', [
                'exception' => $e
            ]);
        }
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
