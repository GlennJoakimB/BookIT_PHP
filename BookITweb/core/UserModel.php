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

    public Array $relatedObjects = []; 

    public string $role = self::ROLE_USER;
    abstract public function getDisplayName(): string;

    /**
     * @return array of objects that are related to the user
     */
    abstract public function getRelatedObjectsReferences(): array;

    public function getRelatedObjects(): array
    {
        $relatedObjects = [];
        foreach ($this->getRelatedObjectsReferences() as $relatedObjectReference) {
            $relatedObjects[] = $this->getRelatedObject($relatedObjectReference);
        }
        return $relatedObjects;
    }

    public function getRelatedObject(string $relatedObjectReference): object
    {
        if (isset($this->relatedObjects[$relatedObjectReference])) {
            return $this->relatedObjects[$relatedObjectReference];
        }
        $relatedObject = $this->getRelatedObjectFromDb($relatedObjectReference);
        $this->relatedObjects[$relatedObjectReference] = $relatedObject;
        return $relatedObject;
    }

    protected function getRelatedObjectFromDb(string $relatedObjectReference): object
    {
        $relatedObjectClass = $this->getRelatedObjectClass($relatedObjectReference);
        $relatedObject = new $relatedObjectClass();
        $relatedObject->load($this->getRelatedObjectQuery($relatedObjectReference));
        return $relatedObject;
    }

    protected function getRelatedObjectClass(string $relatedObjectReference): string
    {
        //key is the reference, value is the class
        $referenceClassMap = $this->getRefernceClassMap();
        if (!isset($referenceClassMap[$relatedObjectReference])) {
            throw new \Exception("Class reference $relatedObjectReference not found in reference class map");
        }
        return $referenceClassMap[$relatedObjectReference];
    }

    abstract protected function getRelatedObjectQuery(string $relatedObjectReference): string;

    /**
     * @return array  [Reference => class] of classes that are related to the user
     */
    abstract protected function getRefernceClassMap() : array;

}