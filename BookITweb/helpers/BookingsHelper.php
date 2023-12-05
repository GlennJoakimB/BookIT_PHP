<?php

namespace app\helpers
{
    use app\core\Application;
    use app\core\UserModel;
    use app\models\Course;
    use app\models\CourseMembership;
    use app\models\User;

    /**
     * BookingsHelper holds additional functions related to handeling bookings
     *
     * @version 1.0
     * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
     * @package app\helpers
     */
    class BookingsHelper
    {


        /**
         * Sorts and groups together bookings
         * @param array $inputBookings Unordered array of bookings
         * @return array Bookings grouped
         */
        public static function groupBookings(array $inputBookings): array
        {
            if (empty($inputBookings)) {
                return [];
            }

            //group together existing bookings
            $bookingGroups = array();
            foreach ($inputBookings as $booking) {
                $bookingGroups[$booking->getDate() . $booking->holder_id][] = $booking;
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
        public static function groupBookingsByCourse(array $inputBookings): array
        {
            if (empty($inputBookings)) {
                return [];
            }

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
        public static function strToMinutes(string $input): int
        {
            $time = explode(":", $input);
            return intval($time[0]) * 60 + intval($time[1]);
        }

        /**
         * Converts int of minutes into string in HH:mm format
         * @param int $minutes
         * @return string
         */
        public static function minutesToStr(int $minutes): string
        {
            $x = ($minutes % 60);

            //if x minutes is less than 10, add a 0 in front
            return intval($minutes / 60) . ':' . ($x < 10 ? '0' . $x : $x);
        }

        /**
         * Gets courses and creates a list for use in selection-inputs.
         *
         * @return array List with pairs of course id and name
         */
        public static function getSelectableCourses(): array
        {
            $courses = array();
            if (Application::isRole(UserModel::ROLE_ADMIN)) {
                //find every course
                $courses = Course::findMany(['status' => 1]);
            } else {
                //find active courses for current user
                $course_membership = CourseMembership::findMany(['user_id' => Application::$app->user->id]);

                foreach ($course_membership as $mem) {
                    $courses[] = Course::findOne(['status' => 1, 'id' => $mem->course_id]);
                }
            }

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

        /**
         * Generates an array of index and displayname of selectable assistants
         *
         * @param int|null $courseId
         * @return array List with pairs of id and display-names
         */
        public static function getSelectableLAs(int|null $courseId): array
        {
            if ($courseId == null) {
                return [];
            }
            $la_users = CourseMembership::findMany(['teachingAssistant' => 1, 'course_id' => $courseId]);

            //set default value
            $la_select_list = [0 => 'Select'];

            if (!empty($la_users)) {
                foreach ($la_users as $la) {
                    $la_select_list[$la->user_id] = User::findOne(['id' => $la->user_id])->getDisplayName();
                }
            }

            //return array
            return $la_select_list;
        }


        public static function getCommingBookings(array $bookings):array
        {
            $currentDate = date('Y-m-d');
            $returnArray = array();



            return $bookings;
        }
    }
}