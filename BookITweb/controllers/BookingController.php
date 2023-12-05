<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\core\UserModel;
    use app\helpers\BookingsHelper;
    use app\models\Booking;
    use app\models\CourseMembership;
    use app\core\Response;
    use app\models\Course;
    use app\models\User;
    use app\helpers;

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
        /**
         * Logic for showing the booking page
         * @param Request $request
         * @param Response $response
         * @return array|string
         */
        public function booking(Request $request, Response $response):array|void
        {
            //base model for the contact form
            $bookingform = new Booking();
            $courses = BookingsHelper::getSelectableCourses();

            //set default filter values
            $filterCourseId = array_key_first($courses);
            $laFilterId = 0;

            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());

                //update filtervalues
                $filterCourseId = $bookingform->course_id;
                $laFilterId = $bookingform->holder_id;

                if ($bookingform->submit == 'save') {
                    //variable to signal an error was hit
                    $error = false;

                    if (!$booking->validate()) {
                        Application::$app->session->setFlash('error', 'Some input was not valid.');
                        $error = true;
                    }

                    //try to save
                    if (!$booking->save()) {
                        Application::$app->session->setFlash('error', 'Something went wrong when attempting to save new booking.');
                        //return $response->redirect('/booking/setup');
                        $error = true;
                    }

                    //if no error, succsess
                    if (!$error) {
                        Application::$app->session->setFlash('success', 'Your booking registrated.');
                        return $response->redirect('/booking');
                    }
                }
            }

            //get models from db
            $bookingWhere = ($laFilterId == 0) ?
                ['status' => 1, 'course_id' => $filterCourseId] :
                ['status' => 1, 'course_id' => $filterCourseId, 'holder_id' => $laFilterId];

            $bookings = Booking::findMany($bookingWhere);

            $teacherAssistants = BookingsHelper::getSelectableLAs($filterCourseId);

            //find name of coresponding course and add it to each booking
            if (!empty($bookings) && !empty($courses)) {
                foreach ($bookings as $booking) {
                    //get course_name from array, where:
                    $booking->course_name = $courses[$booking->course_id];
                }
            }

            //group together existing bookings
            $bookings = BookingsHelper::groupBookings($bookings);

            //render the booking page, with the booking model
            return $this->render('booking', [
                'model' => $bookingform,
                'activeBookingGroups' => $bookings,
                'courses' => $courses,
                'la' => $teacherAssistants
            ]);
        }


        /**
         * Logic for setting up bookings
         * @param Request $request
         * @param Response $response
         * @return array|string
         */
        public function bookingSetup(Request $request, Response $response)
        {
            //base model for the contact form
            $bookingform = new Booking();

            //preview of bookings
            $bookingPrev = array();

            $duration = $bookingform->getSelectableDuration();
            $break = $bookingform->getSelectableBreaks();

            //get data from db
            $existingBookings = Booking::findMany(['status' => 1, 'holder_id' => (Application::$app->user->id)]);
            $courses = BookingsHelper::getSelectableCourses();

            //populate every
            if (!empty($existingBookings)) {
                foreach ($existingBookings as $booking) {
                    $booking->holder = Application::$app->user->getDisplayName();;
                }
            }

            //find name of coresponding course and add it to each booking
            if (!empty($existingBookings) && !empty($courses)) {
                foreach ($existingBookings as $booking) {
                    //get course_name from array, where:
                    $booking->course_name = $courses[$booking->course_id];
                }
            }

            //group together existing bookings
            $existingBookingGroups = BookingsHelper::groupBookings($existingBookings);

            //group by course
            $courseOrderedBookings = BookingsHelper::groupBookingsByCourse($existingBookingGroups);



            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());
                Application::$app->session->removeFlashMessages();

                //validate and create booking
                if ($bookingform->validate()) {
                    //if submit-value is 'add', only generate preview

                    //if duration is longer than end_time
                    $var_form_duration = BookingsHelper::strToMinutes($bookingform->getEndTime()) - BookingsHelper::strToMinutes($bookingform->getStartTime());
                    if ($bookingform->booking_duration > $var_form_duration) {
                        Application::$app->session->setFlash('error', 'Duration is longer than the specified end-time.');
                    }

                    //setting counter variable
                    $interval = $bookingform->booking_duration;
                    $breakDuration = $bookingform->break;
                    $next_start = BookingsHelper::strToMinutes($bookingform->start_time);


                    //loop until reaching the specified end time, or within.
                    while (($next_start + $interval) <= BookingsHelper::strToMinutes($bookingform->end_time)) {
                        //initialise new booking
                        $newBooking = new Booking();

                        //give it same data, then update fields
                        $newBooking->loadData($request->getBody());
                        $newBooking->holder_id = Application::$app->user->id;
                        $newBooking->holder = Application::$app->user->getDisplayName();

                        //update time
                        $newBooking->start_time = BookingsHelper::minutesToStr($next_start);
                        $next_start += $interval;

                        $newBooking->end_time = BookingsHelper::minutesToStr($next_start);
                        $next_start += $breakDuration;

                        //store new booking
                        $bookingPrev[] = $newBooking;
                    }

                    //if submit-value is 'create', send to db
                    if ($bookingform->submit == 'save') {
                        //save all bookings
                        $error = false;

                        foreach ($bookingPrev as $booking) {
                            if (!$booking->validate()) {
                                Application::$app->session->setFlash('error', 'Some input was not valid.');
                                $error = true;
                            }

                            //update star_time to db-format
                            $booking->start_time = $booking->date . ' ' . $booking->start_time . ':00';
                            $booking->end_time = $booking->date . ' ' . $booking->end_time . ':00';


                            //TODO: If user is attempting to create over an existing period, give error


                            //try to save
                            if (!$booking->save()) {
                                Application::$app->session->setFlash('error', 'Something went wrong when attempting to save new booking.');
                                //return $response->redirect('/booking/setup');
                                $error = true;
                            }
                        }

                        //if no error, succsess
                        if (!$error) {
                            Application::$app->session->setFlash('success', 'Your booking is now created.');
                            return $response->redirect('/booking/setup');
                        }
                    }
                }
            }

            //render page with given paramaters
            return $this->render('bookingSetup', [
                'model' => $bookingform,
                'bookingPreview' => $bookingPrev,
                'existingBookingGroups' => $courseOrderedBookings,
                'courses' => $courses,
                'duration' => $duration,
                'breakList' => $break
            ]);
        }
    }
}