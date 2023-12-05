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
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;

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
        public function getCourseMemberships(): array{
            $membership = CourseMembership::findMany(['user_id' => $this->id]);

            $mem_list = array();
            foreach($membership as $mem) {
                $mem_list[$mem->course_id] = $mem->teachingAssistant;
            }

            //store and return array
            $this->course_memberships = $mem_list;
            return $this->course_memberships;
        }

        public function isTeacherAssistant():bool{
            $var = false;
            if(!empty($this->course_memberships)) {
                foreach($this->course_memberships as $membership) {
                    if($membership->teachingAssistant == 1) {
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

    }
}