<?php

class m0002_Add_role_to_users
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE users ADD COLUMN role varchar(50) NOT NULL DEFAULT 'user';";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE users DROP COLUMN role;";
        $db->pdo->exec($SQL);
    }
}