<?php

namespace app\core
{
	/**
	 * View short summary.
	 *
	 * View handels all rendering of views and layouts and is the base for all views.
	 *
	 * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core
	 */
	class View
	{
		public string $title = '';

        public function renderView($view, $params = [])
        {
            $viewContent = $this->renderOnlyView($view, $params);
            $layoutContent = $this->layoutContent();

            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        public function renderContent($viewContent)
        {
            $layoutContent = $this->layoutContent();
            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        protected function layoutContent()
        {
            $layout = Application::$app->layout;
            if (isset(Application::$app->controller)) {
                $layout = Application::$app->controller->layout;
            }
            ob_start();
            include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
            return ob_get_clean();
        }

        protected function renderOnlyView($view, $params)
        {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
            ob_start();
            include_once Application::$ROOT_DIR . "/views/$view.php";
            return ob_get_clean();
        }
	}
}