<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\helpers\BookingsHelper;
    use app\models\Booking;
    use app\models\ContactForm;
    use app\core\Response;
    use app\models\Course;
    use app\models\CourseMembership;

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
        public function home(Request $request, Response $response)
        {
            $courses = Course::findMany(['status' => 1]);
            $membership = new CourseMembership();
            $userMemberships = array();

            if(!Application::isGuest()) {
                $user = Application::$app->user;
                if ($user != null) {
                    $userMemberships = $user->getSelectableCourseMemberships();
                }
            }

            if ($request->isPost()) {
                if (Application::isGuest()) {
                    Application::$app->session->setFlash('error', 'That action requires you to be logged in.');
                    //return $response->redirect('/');
                }

                //get post body
                $membership->loadData($request->getBody());

                //assign the submitted course_id value
                $membership->course_id = intval($membership->submit);
                $membership->user_id = Application::$app->user->id;

                //if the course id already is registered, do nothing
                if (array_key_exists($membership->course_id, $userMemberships)) {
                    Application::$app->session->setFlash('error', 'You have already joined this course.');
                } elseif ($membership->validate() && $membership->save()) {
                    Application::$app->session->setFlash('success', 'Successfully joined a course.');
                }
                return $response->redirect('/');
            }

            //renders the home page on get and post
            $params = [
                'name' => !Application::isGuest() ? 'Welcome ' . Application::$app->user->getDisplayName() : '',
                'model' => $membership,
                'activeCourse' => $courses,
                'memberships' => $userMemberships
            ];
            return $this->render('home', $params);

        }

        //logic for the contact page
        public function contact(Request $request, Response $response)
        {
            //base model for the contact form
            $contact = new ContactForm();

            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $contact->loadData($request->getBody());
                //validate and send the email, Send currently not implemented
                if ($contact->validate() && $contact->send()) {
                    Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                    return $response->redirect('/contact');
                }
            }
            //render the contact page, with the contact model
            return $this->render('contact', [
                'model' => $contact
            ]);
        }

        public function dashboard()
        {
            //get data from db
            $currentBookings = Booking::findMany(['booker_id' => Application::$app->session->get('user')]);
            $currentBookings = BookingsHelper::getCommingBookings($currentBookings);
            $courses = BookingsHelper::getSelectableCourses();

            //populate every
            if (!empty($currentBookings)) {
                foreach ($currentBookings as $booking) {
                    $booking->holder = Application::$app->user->getDisplayName();
                }
            }

            //find name of coresponding course and add it to each booking
            if (!empty($currentBookings) && !empty($courses)) {
                foreach ($currentBookings as $booking) {
                    //get course_name from array, where:
                    $booking->course_name = $courses[$booking->course_id];
                }
            }


            //group together existing bookings
            $currentGroupedBookings = BookingsHelper::groupBookings($currentBookings);

            //group by course
            $currentBookings = BookingsHelper::groupBookingsByCourse($currentGroupedBookings);



            //render the page
            return $this->render('dashboard', [
                'bookings' => $currentBookings
                ]);
        }
    }
}