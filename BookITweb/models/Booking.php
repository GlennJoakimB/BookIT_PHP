<?php

namespace app\models
{
    use app\core\db\DbModel;

    /**
     * Booking short summary.
     *
     * Booking description.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
     */
    class Booking extends DbModel
    {
        const STATUS_AVAILABLE = 0;
        const STATUS_UNAVAILABLE = 1;
        const STATUS_DELETED = 2;

        public ?int $id = 0;
        public int $course_id = 0;
        public string $subject = '';
        public int $holder_id = 0;
        public string $start_time = '';
        public string $end_time = '';
        public ?int $booker_id = 0;
        public ?string $booker_note = '';
        public int $status = 0;
        public string $last_updated = '';
        public int $la_booked = 0;

        public static function tableName(): string
        {
            return 'bookings';
        }

        public static function primaryKey(): string
        {
            return 'id';
        }

        public static function attributes(): array
        {
            //array of attributes, excluding the primary key, last_updated.
            return ['course_id', 'subject', 'holder_id', 'start_time', 'end_time', 'booker_id', 'booker_note', 'status'];
        }

        public function rules(): array
        {
            return [];
        }

        public function labels(): array
        {
            return [
                'booker_note' => 'Booking notes'
            ];
        }

        public function save()
        {
            //format variables
            //$this->status = self::STATUS_INACTIVE;
            //$this->password = password_hash($this->password, PASSWORD_DEFAULT);

            //tell DbModel to save
            return parent::save();
        }

    }
}