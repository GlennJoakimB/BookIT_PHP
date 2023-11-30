<?php

namespace app\core\db
{
    use app\core\Application;
    use app\core\Model;
    use PDO;

    /**
     * DbModel short summary.
     *
     * DbModel extends Model and is the base of each model that is connected to the database. It
     * contains the basic functions for interacting with the database tables.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\core
     */
    abstract class DbModel extends Model
    {
        abstract public static function tableName(): string;
        abstract public function attributes(): array;
        abstract public static function primaryKey(): string;

        /**
         * Base function for saving data to the database. Returns true when process is successful.
         *
         * @return bool
         */
        public function save()
        {
            $tablename = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tablename (" . implode(',', $attributes) . ")
						VALUES (" . implode(',', $params) . ")");

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            return true;
        }

        /**
         * Find one object from db based on paramaters
         *
         * @param mixed $where Paramaters for specifying the result
         * @return bool|object
         */
        public static function findOne($where)
        {
            return static::find($where);
        }

        /**
         * Find all objects from db based on paramaters
         *
         * @param mixed $where Paramaters for specifying the result
         * @return bool|object
         */
        public static function findMany($where)
        {
            return static::find($where, true);
        }

        /**
         * Find requested data in db
         *
         * @param mixed $where Paramaters for specifying the result
         * @param bool $many Whether to return all objects found, or first one
         * @return bool|object
         */
        private static function find($where, bool $many = false)
        {
            $tablename = static::tableName();
            $attributes = array_keys($where);
            $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tablename WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();

            if (!$many) {
                //return first row as object
                return $statement->fetchObject(static::class);
            } else {
                //return all rows found
                return $statement->fetchAll(PDO::FETCH_CLASS, static::class); // static::class);
            }
        }


        public static function prepare($sql)
        {
            return Application::$app->db->pdo->prepare($sql);
        }
    }
}