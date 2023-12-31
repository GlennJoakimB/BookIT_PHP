<?php

namespace app\core\form
{
    use app\core\Model;

    /**
     * InputField short summary.
     *
     * InputField is a class used to set up different types of html form <input> through
     * php.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\form
     */
    class InputField extends BaseField
    {
        public const TYPE_TEXT = 'text';
        public const TYPE_PASSWORD = 'password';
        public const TYPE_NUMBER = 'number';
        public const TYPE_DATE = 'datetime-local';
        public const TYPE_DAY = 'date';
        public const TYPE_TIME = 'time';


        

        public function __construct(Model $model, string $attribute)
        {
            $this->type = self::TYPE_TEXT;
            parent::__construct($model, $attribute);
        }

        public function passwordField()
        {
            $this->type = self::TYPE_PASSWORD;
            return $this;
        }
        public function dateField()
        {
            $this->type = self::TYPE_DATE;
            return $this;
        }

        public function dayField()
        {
            $this->type = self::TYPE_DAY;
            return $this;
        }

        public function timeField()
        {
            $this->type = self::TYPE_TIME;
            return $this;
        }

        public function numberField()
        {
            $this->type = self::TYPE_NUMBER;
            return $this;
        }



        public function renderInput(): string
        {
            return sprintf(
                '<input type="%s" name="%s" value="%s" class="form-control%s">',
                $this->type,
                $this->attribute,
                $this->model->{$this->attribute},
                $this->model->hasError($this->attribute) ? ' is-invalid' : ''
            );
        }
    }
}