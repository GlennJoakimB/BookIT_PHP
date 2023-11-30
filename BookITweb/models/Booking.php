<?php

namespace app\models
{
    use app\core\db\DbModel;
	/**
	 * Booking short summary.
	 *
	 * Booking description.   00-06, 06-12, 12-18, 18-24  eks 8 bokinger i 12-18 7 er ledig
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
	 */
	class Booking extends DbModel
	{
        protected int $id = 0;
        protected int $course_id = 0;
        protected string $subject = '';
        protected int $holder_id = 0;
        protected string $start_time = '';
        protected string $end_time = '';
        protected ?int $booker_id = 0;
        protected ?string $booker_note = '';
        protected int $status = 0;
        protected string $last_updated = '';

		public function tableName()
        {
            return 'bookings';
        }

        public function primaryKey()
        {
			return 'id';
        }

        public function attributes(): array
        {
            //array of attributes, excluding the primary key, last_updated.
            return ['course_id', 'subject', 'holder_id', 'start_time', 'end_time', 'booker_id', 'booker_note', 'status'];
        }

        public function rules(): array
        {
            //not implemented return empty array
            return [];
        }

    }
}