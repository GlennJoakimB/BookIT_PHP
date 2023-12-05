<?php

namespace app\core;

use app\core\db\Database;
/**
 * Application
 *
 * The core of the framework and the top of the hierarchy.
 * Defines services and properties used by the framework. Responsible for running, and delegating tasks.
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
    public ?UserModel $user;
    public View $view;


    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            try {
                $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
                $this->user->getCourseMemberships();
            }catch(\Exception $e)
            {
                $this->user = null;
            }
        } else {
            $this->user = null;
        }
        echo '<pre>';
        var_dump($this->user);
        echo '</pre>';
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
            echo $this->view->renderView('error', [
                'exception' => $e
            ]);
        }
    }

    public function login(UserModel $user)
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

    public static function isRole(string $role){
        return self::$app->user->role === $role;
    }

    public static function isTeacherAssistant():bool {
        return self::$app->user->isTeacherAssistant();
    }
}
