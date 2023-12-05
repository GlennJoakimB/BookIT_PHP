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
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;


        public int $id = 0;
        public string $name = '';
        public int $status = self::STATUS_INACTIVE;
        public int $owner_id = 0;
        public string $description = '';
        public string $start_date = '';
        public string $end_date = '';
        public ?User $owner = null;

        public static function tableName() : string
        {
            return 'courses';
        }

        public static function primaryKey() : string
        {
            return 'id';
        }

        public static function attributes(): array
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

        public function getOwner()
        {
            //return User::findOne(['id' => $this->owner_id]). And sets local owner;
            $this->owner = User::findOne(['id' => $this->owner_id]);
            return $this->owner;
        }

        public function customSave(bool $isSelfOwner)
        {
            //TODO: check if this logic is redundant later.
            if ($isSelfOwner) {
                $this->owner_id = Application::$app->user->id;
            } else if (is_null($this->owner_id)) {
                $this->owner_id = Application::$app->user->id;
            }
            self::save();
        }

        public function save()
        {
            $this->status = self::STATUS_ACTIVE;

            return parent::save();
        }

	}
}