<?php

namespace app\models
{
    use app\core\UserModel;

    /**
     * RegisterModel short summary.
     *
     * RegisterModel description.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
     */
    class User extends UserModel
    {
        //status constants
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;

        // related object references constants
        const REF_COURSEMEMBERSHIP = 'CourseMembership';
        const REF_COURSEOWNERSHIPS = 'CourseOwnerships';
        public int $id = 0;
        public string $firstname = '';
        public string $lastname = '';
        public string $email = '';
        public int $status = self::STATUS_INACTIVE;
        public string $password = '';
        public string $confirmPassword = '';

        public array $course_memberships = array();

        public static function tableName(): string
        {
            return 'users';
        }

        public static function primaryKey(): string
        {
            return 'id';
        }

        public function getDisplayName(): string
        {
            return $this->firstname . ' ' . $this->lastname;
        }

        /**
         * Generates an array of the course relations of the user
         * @return array
         */
        public function getSelectableCourseMemberships(): array{
            $membership = $this->getRelatedObject(self::REF_COURSEMEMBERSHIP);

            $mem_list = array();
            if(!empty($membership)) {
                foreach($membership as $mem) {
                    $mem_list[$mem->course_id] = $mem->teachingAssistant;
                }
            }

            //return array
            return $mem_list;
        }

        public function isTeacherAssistant():bool{
            $var = false;
            $mem_list = $this->getSelectableCourseMemberships();
            if(!empty($mem_list)) {
                foreach($mem_list as $mem_status) {
                    //See if the value "teachingAssistant" is 1
                    if($mem_status == 1) {
                        $var = true;
                    }
                }
            }
            return $var;
        }

        public function save()
        {
            $this->status = self::STATUS_ACTIVE;
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);

            return parent::save();
        }

        public function rules(): array
        {
            return [
                'firstname' => [self::RULE_REQUIRED],
                'lastname' => [self::RULE_REQUIRED],
                'email' => [
                    self::RULE_REQUIRED,
                    self::RULE_EMAIL,
                    [
                        self::RULE_UNIQUE,
                        'class' => self::class
                    ]
                ],
                'password' => [
                    self::RULE_REQUIRED,
                    [self::RULE_MIN, 'min' => 8],
                    self::RULE_PWD_STRENGTH,
                    [self::RULE_MAX, 'max' => 24]
                ],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
            ];
        }

        public static function attributes(): array
        {
            return ['firstname', 'lastname', 'email', 'password', 'status'];
        }

        public function labels(): array
        {
            return [
                'firstname' => 'First Name',
                'lastname' => 'Last Name',
                'email' => 'Email',
                'password' => 'Password',
                'confirmPassword' => 'Confirm Password'
            ];
        }


        /**
         * @return array of objects that are related to the user
         */
        function getRelatedObjectsReferences(): array
        {
            return [ self::REF_COURSEMEMBERSHIP, self::REF_COURSEOWNERSHIPS];
        }

        function getRefernceClassMap(): array
        {
            return [self::REF_COURSEMEMBERSHIP => '\app\models\CourseMembership', self::REF_COURSEOWNERSHIPS => 'app\models\Course'];
        }
        /**
         *
         * @param string $relatedObjectReference
         * @return string
         */
        function getRelatedObjectQueryParams(string $relatedObjectReference): array
        {
            //Key is switch case, value is the array of params where Key is DB column and value is value
            switch ($relatedObjectReference) {
                case 'CourseMembership':
                    return ['user_id'=> $this->id];
                case 'CourseOwnerships':
                    return ['owner_id' => $this->id];
                default:
                    throw new \Exception("Class reference $relatedObjectReference not found in reference class map");
            }
        }
    }
}