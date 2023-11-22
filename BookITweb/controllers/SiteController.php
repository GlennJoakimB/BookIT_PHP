<?php

namespace app\controllers
{
    use app\core\Controller;
    use app\core\Request;
	/**
	 * SiteController short summary.
	 *
	 * SiteController description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
	 */
	class SiteController extends Controller
	{
        public function home()
        {
			$params= [
                'name' => "Tom"
            ];
			return $this->render('home', $params);
            
        }
        public function contact()
        {
			return $this->render('contact');
        }
		/**
         * Summary of handleContact
         * @param Request $request 
         * @return string
         */
		public function handleContact(Request $request)
        {
            $body = $request->getBody();
            //var_dump($body);
            echo '<pre>';
            var_dump($body);
            echo '</pre>';

            return "Handling submitted data";
        }
	}
}