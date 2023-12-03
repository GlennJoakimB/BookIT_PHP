<?php

namespace app\core;

use app\core\db\DbModel;

/**
 * Class UserModel
 *
 * UserModel is abstarct class used for types in the core, and is the base of each user model.
 *
 * @version 1.0
 * @author GlennJoakimB <89195051+GlennJoakimB@users.noreply.github.com>
 * @package app\core
 */
abstract class UserModel extends DbModel
{
    public const ROLE_USER = 'user';
    public const ROLE_TEACHER_ASSISTANT = 'teacher_assistant';
    public const ROLE_ADMIN = 'admin';


    public string $role = self::ROLE_USER;
    abstract public function getDisplayName(): string;
}