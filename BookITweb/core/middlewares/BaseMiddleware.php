<?php

namespace app\core\middlewares
{
	/**
	 * BaseMiddleware short summary.
	 *
	 * BaseMiddleware used for types in the core, and is the base of each middleware.
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