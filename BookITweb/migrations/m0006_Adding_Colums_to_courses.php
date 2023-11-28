<?php

class m0006_Adding_Colums_to_courses
{
public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE courses
                ADD COLUMN start_date DATETIME NOT NULL,
                ADD COLUMN end_date DATETIME NOT NULL;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE courses
                DROP COLUMN start_date,
                DROP COLUMN end_date;";
        $db->pdo->exec($SQL);
    }
}