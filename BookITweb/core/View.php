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

        /**
         * Renders a view with layout, if with components. components will be 
         * rendered based on params in key 'components' and 'componentsParams'.
         * @param mixed $view the view to be rendered.
         * @param mixed $params params to be passed to view, components and
         * componentsParams are removed from params.
         * @param bool $withComponents if true, components will be rendered.
         * @return array|string returns rendered view with components.
         */
        public function renderView($view, $params = [], $withComponents = false)
        {
            if ($withComponents) {
                $viewContent = $this->renderViewWithComponent($view, $params);
            }else{
                $viewContent = $this->renderOnlyView($view, $params);
            }
            $layoutContent = $this->layoutContent();

            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        /**
         * Renders a view with components specified in params under key 'components'
         * @param mixed $view the view to be rendered
         * @param mixed $params params to be passed to view, components and componentsParams are removed from params
         * @return array|string returns rendered view with components
         */
        protected function renderViewWithComponent($view, $params = [])
        {
            //setting viewContent to rendered view

            //checking params for components [], params key for components array is 'components'
            if (isset($params['components'])) {
                //getting components array
                $components = $params['components'];
                //removing components from params
                unset($params['components']);

                $componentsParams = [];
                //checking if 'componentsParams' exists in params
                if (isset($params['componentsParams'])) {
                    //getting componentsParams array
                    $incParams = $params['componentsParams'];
                    //removing componentsParams from params
                    unset($params['componentsParams']);
                    //Looping through componentsParams array
                    foreach ($incParams as $key => $value) {
                        //adding componentsParams to params
                        $componentsParams[$key] = $value;
                    }
                }
                //rendering view without components
                $viewContent = $this->renderOnlyView($view, $params);
                //Looping through components array
                foreach ($components as $component) {
                    //rendering component
                    $componentContent = $this->renderComponent($component, $componentsParams);
                    //replacing component placeholder with component content
                    $viewContent = str_replace("{{component.$component}}", $componentContent, $viewContent);
                }
            } else {
                //rendering view without components
                $viewContent = $this->renderOnlyView($view, $params);
            }
            return $viewContent;
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

        //function to render a component
        protected function renderComponent($component, $params = [])
        {
            $selectedComp = Application::$ROOT_DIR . "/views/components/$component.php";
            foreach ($params as $key => $value) {
                $$key = $value;
            }
            ob_start();
            include_once $selectedComp;
            return ob_get_clean();
        }
	}
}