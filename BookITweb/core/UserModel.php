<?php

namespace app\core;

use app\core\db\DbModel;
/**
 * Class UserModel
 *
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
