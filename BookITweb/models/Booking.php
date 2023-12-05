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
        const STATUS_DELETED = 0;
        const STATUS_AVAILABLE = 1;
        const STATUS_UNAVAILABLE = 2;

        public ?int $id = 0;
        public int $course_id = 0;
        public string $course_name = '';
        public string $subject = '';
        public int $holder_id = 0;
        public string $holder = '';
        public string $date = '';
        public string $start_time = '  ';
        public string $end_time = '  ';
        public ?int $booker_id = null;
        public ?string $booker = null;
        public ?string $booker_note = '';
        public int $status = 0;
        public string $last_updated = '';

        //values to hold and store search paramaters
        public int $course_id_search = 0;
        public int $holder_id_search = 0;

        public int $booking_duration = 15;
        public int $break = 0;


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
            return [
                'course_id' => [self::RULE_REQUIRED],
                'subject' => [self::RULE_REQUIRED],
                'date' => [self::RULE_REQUIRED],
                'start_time' => [self::RULE_REQUIRED],
                'end_time' => [self::RULE_REQUIRED]
            ];
        }

        public function labels(): array
        {
            return [
                'course_id' => 'Course',
                'course_id_search' => 'Course',
                'holder_id' => 'Teacher Assistant',
                'holder_id_search' => 'Teacher Assistant',
                'subject' => 'Subject',
                'date' => 'Date',
                'start_time' => 'Start time',
                'end_time' => 'End time',
                'booker_note' => 'Booking Notes',
                'booking_duration' => 'Duration',
                'break' => 'Break time'
            ];
        }


        public function getDate():string
        {
            $str = '';
            if($this->date != '') {
                $str = $this->date;
            } else {
                //remove HH:mm:ss from start_time
                $str = substr($this->start_time, 0 , strpos($this->start_time, ' '));
            }
            return $str;
        }

        public function getStartTime(): string
        {
            //extract HH:mm if time contains date
            $str = substr($this->start_time, strpos($this->start_time, ' '));

            //remove seconds from value
            if (strlen($str) > 5) { $str = substr($str, 0, -3); }
            return $str;
        }

        public function getEndTime(): string
        {
            //extract HH:mm if time contains date
            $str = substr($this->end_time, strpos($this->end_time, ' '));

            //remove seconds from value
            if (strlen($str) > 5) { $str = substr($str, 0, -3); }
            return $str;
        }

        //finds holder from db
        public function getHolder()
        {
            //return User::findOne(['id' => $this->holder_id]) and set local holder;
            $this->holder = User::findOne(['id' => $this->holder_id])->getDisplayName();
            return $this->holder;
        }

        //find booker from db
        public function getBooker()
        {
            //return User::findOne(['id' => $this->booker_id]) and set local booker;
            $this->booker = User::findOne(['id' => $this->booker_id])->getDisplayName();
            return $this->booker;
        }

        public function save()
        {
            //format variables
            $this->status = self::STATUS_AVAILABLE;

            //tell DbModel to save
            return parent::save();
        }

        public function update()
        {
            //tell DbModel to save
            return parent::update();
        }

        public static function getSelectableDuration()
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

        public static function getSelectableBreaks()
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