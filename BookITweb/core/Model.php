<?php

namespace app\core
{
    /**
     * Model
     *
     * Model is the base class for all models, it provides the basic
     * functionality for validation and error handling.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core
     */
    abstract class Model
    {

        public const RULE_REQUIRED = 'required';
        public const RULE_EMAIL = 'email';
        public const RULE_MIN = 'min';
        public const RULE_MAX = 'max';
        public const RULE_MATCH = 'match';
        public const RULE_UNIQUE = 'unique';
        public const RULE_USER_EXISTS = 'user_exists';
        public const RULE_PWD_STRENGTH = 'pwd_strength';

        public string $submit = '';
        public string $bannerError = '';
        public array $errors = [];

        abstract public function rules(): array;

        public function loadData($data)
        {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }


        //returns an array of attributes and their labels
        public function labels(): array
        {
            return [];
        }

        //get the label for a specific attribute
        public function getLabel($attribute)
        {
            return $this->labels()[$attribute] ?? $attribute;
        }

        /**
         * Validate
         *
         * Validate the model fields against the rules defined and specified
         * in the model.
         * @return bool
         */
        public function validate(): bool
        {
            //loop through the rules defined in the model
            foreach ($this->rules() as $attribute => $rules) {
                $value = $this->$attribute;
                //loop through the rules for the attribute
                foreach ($rules as $rule) {
                    $ruleName = $rule;
                    if (!is_string($ruleName)) {
                        //if the rule is not a string, it is an array with the rule name as the first element
                        $ruleName = $rule[0];
                    }
                    //check if the rule is required and if the value is empty
                    if ($ruleName === self::RULE_REQUIRED && !$value) {
                        $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                    }
                    //check if the rule is email and if the value is not a valid email
                    if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addErrorForRule($attribute, self::RULE_EMAIL);
                    }
                    //check if the rule is min and if the value is shorter than the min value
                    if ($ruleName === self::RULE_MIN && strlen($value) < $rule[self::RULE_MIN]) {
                        $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                    }
                    //check if the rule is max and if the value is longer than the max value
                    if ($ruleName === self::RULE_MAX && strlen($value) > $rule[self::RULE_MAX]) {
                        $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                    }
                    //check if the rule is match and if the value is not the same as the match value
                    if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule[self::RULE_MATCH]}) {
                        $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                    }
                    //check if the rule is unique (in database to) and if the value is not unique
                    if ($ruleName === self::RULE_UNIQUE) {
                        $className = $rule['class'];
                        $uniqueAttr = $rule['attribute'] ?? $attribute;
                        $tableName = $className::tableName();
                        $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                        $stmt->bindValue(":attr", $value);
                        $stmt->execute();
                        $record = $stmt->fetchObject();
                        if ($record) {
                            $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        }
                    }
                    if ($ruleName === self::RULE_USER_EXISTS) {
                        //get tablename from application userClass
                        $tableName = Application::$app->userClass::tableName();
                        $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE id = :attr");
                        $stmt->bindValue(":attr", $value);
                        $stmt->execute();
                        $record = $stmt->fetchObject();
                        if (!$record) {
                            $this->addErrorForRule($attribute, self::RULE_USER_EXISTS);
                        }
                    }
                    if ($ruleName === self::RULE_PWD_STRENGTH) {
                        $uppercase = preg_match('@[A-Z]@', $value);
                        $lowercase = preg_match('@[a-z]@', $value);
                        $number = preg_match('@[0-9]@', $value);
                        $specialChars = preg_match('@[^\w]@', $value);
                        if (!$uppercase || !$lowercase || !$number || !$specialChars) {
                            $this->addErrorForRule($attribute, self::RULE_PWD_STRENGTH);
                        }
                    }
                }
            }
            return empty($this->errors);
        }

        //add an error for a specific attribute and rule
        private function addErrorForRule($attribute, $rule, $params = [])
        {
            $message = $this->errorMessages()[$rule] ?? '';
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
            $this->errors[$attribute][] = $message;
        }

        //add an error for a specific attribute
        public function addError($attribute, $message)
        {
            $this->errors[$attribute][] = $message;
        }

        //add a banner error for an entire form
        public function addBannerError(string $error)
        {
            $this->bannerError = sprintf('<div class="alert alert-danger" role="alert">%s</div>', $error);
        }

        //get the error message [] for a specific rule
        public function errorMessages()
        {
            return [
                self::RULE_REQUIRED => 'This field is required',
                self::RULE_EMAIL => 'This field must be a valid email address',
                self::RULE_MIN => 'Min length of this field must be {min}',
                self::RULE_MAX => 'Max length of this field must be {max}',
                self::RULE_MATCH => 'This field must be the same as {match}',
                self::RULE_UNIQUE => 'Record with this {field} already exists',
                self::RULE_USER_EXISTS => 'Invalid User selected, try another.',
                self::RULE_PWD_STRENGTH => 'Password must contain at least 1 uppercase,
                                        1 lowercase, 1 number and 1 special character.'
            ];
        }

        //check if the model has errors
        public function hasError($attribute)
        {
            return $this->errors[$attribute] ?? false;
        }

        //get the first error for a specific attribute
        public function getFirstError($attribute)
        {
            return $this->errors[$attribute][0] ?? false;
        }
    }
}