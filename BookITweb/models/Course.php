<?php

namespace app\models
{
    use app\core\db\DbModel;
	/**
	 * Course short summary.
	 *
	 * Course description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
	 */
	class Course extends DbModel
	{
        protected int $id = 0;
        protected string $name = '';
        protected int $status = 0;
        protected int $owner_id = 0;
        protected string $description = '';
        protected string $start_date = '';
        protected string $end_date = '';

        public function tableName()
        {
            return 'courses';
        }

        public function primaryKey()
        {
            return 'id';
        }

        public function attributes(): array
        {
            return ['name', 'status', 'owner_id', 'description', 'start_date', 'end_date'];
        }

        public function rules(): array
        {
            return [
                'name' => [self::RULE_REQUIRED],
                'owner_id' => [self::RULE_REQUIRED, self::RULE_USER_EXISTS],
                'description' => [self::RULE_REQUIRED],
                'start_date' => [self::RULE_REQUIRED],
                'end_date' => [self::RULE_REQUIRED]
                ];
        }
        
        public function labels(): array
        {
            return [
                'name' => 'Course Title',
                'owner_id' => 'Course Holder',
                'description' => 'Course description',
                'start_date' => 'Course start date',
                'end_date' => 'Course end date'
                ];
        }
	}
}