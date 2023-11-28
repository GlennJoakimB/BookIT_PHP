<?php

namespace app\core
{
    /**
    * Model short summary.
    *
    * Model is the base class for all models, it provides the basic functionality for validation and error handling.
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

        public array $errors = [];

        abstract public function rules(): array;

        public function loadData($data)
        {
            foreach($data as $key => $value)
            {
                if(property_exists($this, $key))
                {
                    $this->$key = $value;
                }
            }
        }

        public function labels(): array
        {
            return [];
        }

        public function getLabel($attribute)
        {
            return $this->labels()[$attribute] ?? $attribute;
        }

        public function validate(): bool
        {
            foreach($this->rules() as $attribute => $rules)
            {
                $value = $this->$attribute;
                foreach($rules as $rule)
                {
                    $ruleName = $rule;
                    if(!is_string($ruleName))
                    {
                        $ruleName = $rule[0];
                    }
                    if($ruleName === self::RULE_REQUIRED && !$value)
                    {
                        $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                    }
                    if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                    {
                        $this->addErrorForRule($attribute, self::RULE_EMAIL);
                    }
                    if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                    {
                        $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                    }
                    if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                    {
                        $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                    }
                    if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                    {
                        $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                    }
                    if($ruleName === self::RULE_UNIQUE)
                    {
                        $className = $rule['class'];
                        $uniqueAttr = $rule['attribute'] ?? $attribute;
                        $tableName = $className::tableName();
                        $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                        $stmt->bindValue(":attr", $value);
                        $stmt->execute();
                        $record = $stmt->fetchObject();
                        if($record)
                        {
                            $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        }
                    }
                    if($ruleName === self::RULE_USER_EXISTS)
                    {
                        //get tablename from application userClass
                        $tableName = Application::$app->userClass::tableName();
                        $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE id = :attr");
                        $stmt->bindValue(":attr", $value);
                        $stmt->execute();
                        $record = $stmt->fetchObject();
                        if(!$record)
                        {
                            $this->addErrorForRule($attribute, self::RULE_USER_EXISTS);
                        }
                    }
                    if($ruleName === self::RULE_PWD_STRENGTH)
                    {
                        $uppercase = preg_match('@[A-Z]@', $value);
                        $lowercase = preg_match('@[a-z]@', $value);
                        $number    = preg_match('@[0-9]@', $value);
                        $specialChars = preg_match('@[^\w]@', $value);
                        if(!$uppercase || !$lowercase || !$number || !$specialChars)
                        {
                            $this->addErrorForRule($attribute, self::RULE_PWD_STRENGTH);
                        }
                    }
                }
            }
            return empty($this->errors);
        }

        private function addErrorForRule($attribute, $rule, $params = [])
        {
            $message = $this->errorMessages()[$rule] ?? '';
            foreach($params as $key => $value)
            {
                $message = str_replace("{{$key}}", $value, $message);
            }
            $this->errors[$attribute][] = $message;
        }

        public function addError($attribute, $message)
        {
            $this->errors[$attribute][] = $message;
        }

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

        public function hasError($attribute)
        {
            return $this->errors[$attribute] ?? false;
        }

        public function getFirstError($attribute)
        {
            return $this->errors[$attribute][0] ?? false;
        }
    }
}