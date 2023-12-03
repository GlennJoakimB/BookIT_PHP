<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\models\Booking;
    use app\core\Response;
    use app\models\Course;

    /**
     * BookingController
     *
     * BookingController manages the logic of booking pages.
     *
     * @version 1.0
     * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
     * @package app\controllers
     */
    class BookingController extends Controller
    {
        //logic for the booking page
        public function booking(Request $request, Response $response)
        {
            //base model for the contact form
            $bookingform = new Booking();

            //get available bookings from db
            $bookings = Booking::findMany(['status' => 1]);
            $courses = $this->getSelectableCourses(['status' => 1]);

            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());

                //validate and create booking
                if ($bookingform->validate() && $bookingform->save()) {
                    Application::$app->session->setFlash('success', 'Your booking is registered.');
                    return $response->redirect('/booking');
                }
            }
            //render the booking page, with the booking model
            return $this->render('booking', [
                'model' => $bookingform,
                'bookings' => $bookings,
                'courses' => $courses
            ]);
        }

        //logic related to seting up bookings
        public function bookingSetup(Request $request, Response $response)
        {
            //base model for the contact form
            $bookingform = new Booking();

            //preview of bookings
            $bookingPrev = array();

            //get data from db
            $existingBookings = Booking::findMany(['status' => 1, 'holder_id' => (Application::$app->user->id)]);
            $courses = $this->getSelectableCourses(['status' => 1]);

            //find name of coresponding course and add it to each booking
            if (!empty($existingBookings) && !empty($courses)) {
                foreach ($existingBookings as $booking) {
                    //get course_name from array, where
                    $booking->course_name = $courses[$booking->course_id];
                }
            }

            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());

                //validate and create booking
                if ($bookingform->validate())
                {
                    //TODO: Add logic for bulk-creation of bookings

                    //if submit-value is 'add', only generate preview
                    echo '<pre>';
                    var_dump($request->getBody());
                    echo '</pre>';

                    //if submit-value is 'create', send to db

                }
            }



            return $this->render('bookingSetup', [
                'model' => $bookingform,
                'bookingPreview' => $bookingPrev,
                'existingBookings' => $existingBookings,
                'courses' => $courses
            ]);
        }

        /**
         * Gets courses and creates a list for use in selection-inputs.
         *
         * @param array $array Search parameters
         * @return array List with pairs of course id and name
         */
        private function getSelectableCourses(array $array):array
        {
            $courses = Course::findMany($array);

            //create array with pairs of course id and name, for use in selection list
            $course_select_list = array();
            if (!empty($courses)) {
                foreach ($courses as $course) {
                    $course_select_list[$course->id] = $course->name;
                }
            }

            //return array
            return $course_select_list;
        }
    }
}