<?php

namespace app\models
{
    use app\core\db\DbModel;

    /**
     * CourseMembership short summary.
     *
     * CourseMembership description.
     *
     * @version 1.0
     * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
     * @package app\models
     */
    class CourseMembership extends DbModel
    {

        public int $id = 0;
        public int $course_id = 0;
        public int $user_id = 0;
        public int $teachingAssistant = 0;

        
        
        public static function tableName(): string
        {
            return 'course_members';
        }

        public static function primaryKey(): string
        {
            return 'id';
        }

        public static function attributes(): array
        {
            //array of attributes, excluding the primary key, last_updated.
            return ['course_id', 'user_id', 'teachingAssistant'];
        }

        public function rules(): array
        {
            return [];
        }

        public function labels(): array
        {
            return [];
        }


        public function save()
        {
            //format variables

            //tell DbModel to save
            return parent::save();
        }

    }
}