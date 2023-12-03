<?php

namespace app\core\form
{
    use app\core\Model;
	/**
	 * Form short summary.
	 *
	 * Form is a class that is used to create html forms.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\form
	 */
	class Form
	{
		/**
		 * Begins a new form using given variables
         * 
		 * @param mixed $action The action the form with preform when submitting data. 
		 * @param mixed $method post or get.
		 * @param mixed $id Gives an id to the form.
		 * @return Form
		 */
		public static function begin($action, $method, $id = '')
        {
            echo sprintf('<form action="%s" method="%s" id="%s">', $action, $method, $id);
            return new Form();
        }

        public static function end()
        {
            echo '</form>';
        }

        public function field(Model $model, $attribute)
        {
            return new InputField($model, $attribute);
        }

        public function selectionField(Model $model, $attribute)
        {
            return new SelectField($model, $attribute);
        }
	}
}