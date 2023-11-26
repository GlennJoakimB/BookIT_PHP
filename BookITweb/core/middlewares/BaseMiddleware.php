<?php

namespace app\core\middlewares
{
	/**
	 * BaseMiddleware short summary.
	 *
	 * BaseMiddleware description.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core\middlewares
	 */
	abstract class BaseMiddleware
	{
		abstract public function execute();
	}
}