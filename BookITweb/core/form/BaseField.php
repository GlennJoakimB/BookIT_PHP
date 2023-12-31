<?php

namespace app\core\form
{
    use app\core\Model;
	/**
	 * BaseField short summary.
	 *
	 * BaseField is the base class for all form fields.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\form
	 */
	abstract class BaseField
	{
        public const TYPE_HIDDEN = 'hidden';

        public Model $model;
        public string $attribute;

        public string $type = '';

        /**
         * Field constructor.
         * @param Model $model
         * @param string $attribute
         */
        public function __construct(Model $model, string $attribute)
        {
            $this->model = $model;
            $this->attribute = $attribute;
        }

        abstract public function renderInput(): string;

        public function __toString()
        {
            if ($this->type != self::TYPE_HIDDEN) {
                return sprintf('
            <div class="mb-3">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
            ',
                    $this->model->getLabel($this->attribute),
                    $this->renderInput(),
                    $this->model->getFirstError($this->attribute)
                );
            }else{
                return $this->renderInput();
            }
        }
        public function hiddenField()
        {
            $this->type = self::TYPE_HIDDEN;
            return $this;
        }
	}
}