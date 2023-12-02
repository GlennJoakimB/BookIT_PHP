<?php

namespace app\core\form
{
    /**
     * SelectField short summary.
     *
     * SelectField class for handling selection fields
     *
     * @version 1.0
     * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
     * @package app\core\form
     */

    class SelectField extends BaseField
    {

        private string $options = '';


        /**
         * Creates a set of option-elements based on input
         * 
         * @param array $options Pairs of value and label
         * @return SelectField
         */
        public function setOptions(array $options)
        {
            //variable to hold the combined string
            $optionsList = '';

            //create a formated string for each option from input
            foreach ($options as $value => $label) {
                $optionsList .= sprintf(
                    '<option value="%s"%s>%s</option>',
                    $value,
                    ($this->model->{$this->attribute} == $value) ? ' selected' : '',
                    $label
                );
            }

            $this->options = $optionsList;
            return $this;
        }

        public function renderInput(): string
        {
            return sprintf(
                '<select name="%s" class="form-control form-select%s">%s</select>',
                $this->attribute,
                $this->model->hasError($this->attribute) ? ' is-invalid' : '',
                $this->options
            );
        }
    }
}