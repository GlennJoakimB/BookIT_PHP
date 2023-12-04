<?php

namespace app\controllers
{
    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\models\Booking;
    use app\models\CourseMembership;
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
        /**
         * Logic for showing the booking page
         * @param Request $request
         * @param Response $response
         * @return array|string
         */
        public function booking(Request $request, Response $response)
        {
            //base model for the contact form
            $bookingform = new Booking();

            //get available bookings from db
            $bookings = Booking::findMany(['status' => 1]);
            $courses = $this->getSelectableCourses(['status' => 1]);
            $teacherAssistants = CourseMembership::findMany(['teachingAssistant' => 1]);

            //find name of coresponding course and add it to each booking
            if (!empty($bookings) && !empty($courses)) {
                foreach ($bookings as $booking) {
                    //get course_name from array, where:
                    $booking->course_name = $courses[$booking->course_id];
                }
            }

            //group together existing bookings
            $bookings = $this->groupBookings($bookings);

            //group by course
            $courseOrderedBookings = $this->groupBookingsByCourse($bookings);

            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());


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
            //render the booking page, with the booking model
            return $this->render('booking', [
                'model' => $bookingform,
                'bookings' => $courseOrderedBookings,
                'courses' => $courses,
                'la' => [
                    1 => 'Bob', 
                    5 => 'Tore'
                    ] //$teacherAssistants
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

            $duration = $this->getSelectableDuration();
            $break = $this->getSelectableBreaks();

            //get data from db
            $existingBookings = Booking::findMany(['status' => 1, 'holder_id' => (Application::$app->user->id)]);
            $courses = $this->getSelectableCourses(['status' => 1]);

            //find name of coresponding course and add it to each booking
            if (!empty($existingBookings) && !empty($courses)) {
                foreach ($existingBookings as $booking) {
                    //get course_name from array, where:
                    $booking->course_name = $courses[$booking->course_id];
                }
            }

            //group together existing bookings
            $existingBookingGroups = $this->groupBookings($existingBookingGroups);

            //group by course
            $courseOrderedBookings = $this->groupBookingsByCourse($existingBookingGroups);



            //if the request is post, load the data from the request body
            if ($request->isPost()) {
                $bookingform->loadData($request->getBody());
                Application::$app->session->removeFlashMessages();

                //validate and create booking
                if ($bookingform->validate()) {
                    //if submit-value is 'add', only generate preview

                    //if duration is longer than end_time
                    $var_form_duration = $this->strToMinutes($bookingform->getEndTime()) - $this->strToMinutes($bookingform->getStartTime());
                    if ($bookingform->booking_duration > $var_form_duration) {
                        Application::$app->session->setFlash('error', 'Duration is longer than the specified end-time.');
                    }

                    //interval in minutes
                    $interval = $bookingform->booking_duration;
                    $breakDuration = $bookingform->break;
                    $next_start = $this->strToMinutes($bookingform->start_time);

                    //loop until reaching the specified end time, or within.
                    while (($next_start + $interval) <= $this->strToMinutes($bookingform->end_time)) {
                        //initialise new booking
                        $newBooking = new Booking();

                        //give it same data, then update fields
                        $newBooking->loadData($request->getBody());

                        //generate group_id
                        $newBooking->holder_id = Application::$app->user->id;
                        $newBooking->group_id = $newBooking->holder_id . '_' . $bookingform->date . '_' . $bookingform->start_time;

                        //update time
                        $newBooking->start_time = $this->minutesToStr($next_start);
                        $next_start += $interval;

                        $newBooking->end_time = $this->minutesToStr($next_start);
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
                'existingBookings' => $courseOrderedBookings,
                'courses' => $courses,
                'duration' => $duration,
                'breakList' => $break
            ]);
        }

        /**
         * Sorts and groups together bookings
         * @param array $inputBookings Unordered array of bookings
         * @return array Bookings grouped by group_id
         */
        private function groupBookings(array $inputBookings):array
        {
            if(empty($inputBookings)) {return [];}

            //group together existing bookings
            $bookingGroups = array();
            foreach ($inputBookings as $booking) {
                $bookingGroups[$booking->group_id][] = $booking;
            }
            //sort array in ascending order based on key
            ksort($bookingGroups);

            return $bookingGroups;
        }

        /**
         * This function groups booking-sessions together based on the courses they are related to
         * @param array $inputBookings 
         * @return array
         */
        private function groupBookingsByCourse(array $inputBookings):array
        {
            if(empty($inputBookings)) {
                return [];}

            //group by course
            $courseOrderedBookings = array();
            foreach ($inputBookings as $groups) {
                $courseOrderedBookings[$groups[0]->course_name][] = $groups;
            }
            //sort array in ascending order based on key
            ksort($courseOrderedBookings);

            return $courseOrderedBookings;
        }


        /**
         * Turns strings in HH:mm format and converts into int of total minutes
         * @param string $input
         * @return int Total amount of minutes
         */
        private function strToMinutes(string $input): int
        {
            $time = explode(":", $input);
            return intval($time[0]) * 60 + intval($time[1]);
        }

        /**
         * Converts int of monutes into string in HH:mm format
         * @param int $minutes
         * @return string
         */
        private function minutesToStr(int $minutes): string
        {
            $x = ($minutes % 60);

            //if x minutes is less than 10, add a 0 in front
            return intval($minutes / 60) . ':' . ($x < 10 ? '0' . $x : $x);
        }

        /**
         * Gets courses and creates a list for use in selection-inputs.
         *
         * @param array $array Search parameters
         * @return array List with pairs of course id and name
         */
        private function getSelectableCourses(array $array): array
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

        private function getSelectableDuration()
        {
            return [
                5 => '5 min',
                10 => '10 min',
                15 => '15 min',
                20 => '20 min',
                25 => '25 min',
                30 => '30 min',
                35 => '35 min',
                40 => '40 min',
                45 => '45 min',
                50 => '50 min',
                55 => '55 min',
                60 => '60 min'
            ];
        }

        private function getSelectableBreaks()
        {
            return [
                0 => 'none',
                5 => '5 min',
                10 => '10 min',
                15 => '15 min',
                20 => '20 min',
                25 => '25 min',
                30 => '30 min',
                35 => '35 min',
                40 => '40 min',
                45 => '45 min',
                50 => '50 min',
                55 => '55 min',
                60 => '60 min'
            ];
        }
    }
}