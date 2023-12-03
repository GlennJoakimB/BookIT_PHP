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
        abstract public static function attributes(): array;

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
        public function toArray()
        {
            $array = [];
            foreach (static::attributes() as $attribute) {
                $array[$attribute] = $this->{$attribute};
            }
            return $array;
        }

        public function toString()
        {
            return implode('|', self::toArray());
        }

        public function fromString(string $input)
        {
            $array = explode('|', $input);
            $returnArray = [];
            $i = 0;
            foreach(static::attributes() as $attribute){
                $type = gettype($this->{$attribute});
                $sucsessCast = settype($array[$i],$type);
                if(!$sucsessCast){
                    throw new \Exception();
                }
                $returnArray[$attribute] = $array[$i];
                $i++;
            }
            return $returnArray;
        }

        public function update()
        {
            $tablename = $this->tableName();
            $attributes = $this->attributes();
            //get self::primaryKey() value
            $primaryKey = $this->primaryKey();
            $primaryKeyValue = $this->{$primaryKey};
            $attributes = $this->attributes();

            //if primary key is in attributes, remove it
            if (($key = array_search($primaryKey, $attributes)) !== false) {
                unset($attributes[$key]);
            }
            //map attributes to sql syntax
            $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
            $statement = self::prepare("UPDATE $tablename SET " . implode(',', $params) . "
							WHERE $primaryKey = :primaryKey");
            //bind primary key value
            $statement->bindValue(":primaryKey", $primaryKeyValue);
            //bind attributes
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
         * @return bool|object|array
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
         * @return bool|object|array
         */
        private static function find($where, bool $many = false):bool|object|array
        {
            $tablename = static::tableName();
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tablename WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();

            if (!$many) {
                //return first row as object
                return $statement->fetchObject(static::class);
            } else {
                //return array of objects
                return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
            }
        }


        //implement SearchForValues
        public static function SearchForValues($where)
        {
            $tablename = static::tableName();
            $attributes = array_keys($where);
            $sql = implode(" OR ", array_map(fn($attr) => "$attr LIKE :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tablename WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();
            //return array of objects
            return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        }

        //get all
        public static function findAll()
        {
            $tablename = static::tableName();
            $statement = self::prepare("SELECT * FROM $tablename");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        }

        public static function prepare($sql)
        {
            return Application::$app->db->pdo->prepare($sql);
        }
    }
}