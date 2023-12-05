<?php

namespace app\helpers
{
use app\models\CourseMembership;
use app\models\User;
	/**
	 * CoursesHelper short summary.
	 *
	 * CoursesHelper description.
	 *
	 * @version 1.0
	 * @author Tom
	 */
	class CoursesHelper
	{
        /**
         * Get all members of a course
         * @param string|int $courseId
         * @return CourseMembership[]|array returns an array of CourseMembership objects if found, else an empty array
         */
        public static function getCourseMembers($courseId): array
        {
            $courseMembers = [];
            $AllActiveUsers = [];
            try {
                $courseMembers = CourseMembership::findMany(['course_id' => $courseId]);
                $AllActiveUsers = User::findMany(['status' => User::STATUS_ACTIVE]);
            }catch (\Exception $e)
            {
				return [];
            }
            //match user to course membership and add display name
            foreach ($courseMembers as $member) {
                foreach ($AllActiveUsers as $user) {
                    if ($member->user_id == $user->id) {
                        $member->userDisplayName = $user->getDisplayName();
                    }
                }
            }
            return $courseMembers;
        }

        //Function to get a subset of the members of a course
        public static function getCourseMembersSubset($courseId, $page, $displayAmount, $members = [] ): array
        {
            if(empty($members)){
              $members = self::getCourseMembers($courseId);
            }
            //return subset of members
            return array_slice($members, ($page - 1) * $displayAmount, $displayAmount);
        }
	}
}