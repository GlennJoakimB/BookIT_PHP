<?php

namespace app\core\form
{
	/**
	 * TextareaField short summary.
	 *
	 * TextareaField php class for handling textarea fields
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\form
	 */
	class TextareaField extends BaseField
	{


		public function renderInput(): string
        {
            return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
                $this->attribute,
                $this->model->hasError($this->attribute) ? ' is-invalid' : '',
                $this->model->{$this->attribute}
            );
        }
	}
}