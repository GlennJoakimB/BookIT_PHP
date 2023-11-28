<?php

namespace app\core\exeption
{
	/**
	 * NotFoundExeption short summary.
	 *
	 * NotFoundExeption is thrown when a page is not found.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\exeption
	 */
	class NotFoundExeption extends \Exception
	{
		protected $message = 'Page not found';
        protected $code = 404;
	}
}