<?php

class m0007_Adding_SatusColumn_to_Course_Members
{
public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE course_members ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 0";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "ALTER TABLE course_members DROP COLUMN status";
        $db->pdo->exec($SQL);
    }
}