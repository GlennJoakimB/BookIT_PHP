<?php

namespace app\core\exeption
{
	/**
	 * ForbiddenExeption short summary.
	 *
	 * ForbiddenExeption description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\exeption
	 */
	class ForbiddenExeption extends \Exception
	{
		protected $message = 'You don\'t have permission to access this page';
        protected $code = 403;
	}
}