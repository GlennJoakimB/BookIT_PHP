<?php

namespace app\core\db
{
	use app\core\Application;
    use app\core\Model;
	/**
	 * DbModel short summary.
	 *
	 * DbModel description.
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
		
		public function save()
        {
			$tablename = $this->tableName();
			$attributes = $this->attributes();
			$params = array_map(fn($attr) => ":$attr", $attributes);
			$statement = self::prepare("INSERT INTO $tablename (".implode(',', $attributes).") 
						VALUES (".implode(',', $params).")");
			
			foreach($attributes as $attribute)
			{
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            return true;
		}

        public static function findOne($where)
        {
			$tablename = static::tableName();
			$attributes = array_keys($where);
			$sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
			$statement = self::prepare("SELECT * FROM $tablename WHERE $sql");
			foreach($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
			$statement->execute();
            return $statement->fetchObject(static::class);
        }

		//implement findMany

        public static function prepare($sql)
        {
			return Application::$app->db->pdo->prepare($sql);
        }
    }
}