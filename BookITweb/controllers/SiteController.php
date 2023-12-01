<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\models\ContactForm;
    use app\core\Response;
	/**
	 * SiteController short summary.
	 *
	 * SiteController manages the public accessible pages.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\controllers
	 */
	class SiteController extends Controller
	{
        public function home()
        {
            //renders the home page on get and post
            //Current params are just for testing
			$params= [
                'name' => "Tom"
            ];
			return $this->render('home', $params);
            
        }
        public function contact(Request $request, Response $response)
        {
            //base model for the contact form
            $contact = new ContactForm();

            //if the request is post, load the data from the request body
            if($request->isPost())
            {
                $contact->loadData($request->getBody());
                //validate and send the email, Send currently not implemented
                if($contact->validate() && $contact->send())
                {
                    Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                    return $response->redirect('/contact');
                }
            }
            //render the contact page, with the contact model
			return $this->render('contact',[
                    'model' => $contact
                ]);
        }
	}
}