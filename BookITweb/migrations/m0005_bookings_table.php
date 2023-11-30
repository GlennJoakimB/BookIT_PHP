<?php

class m0005_bookings_table
{
public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            course_id INT NOT NULL,
            subject VARCHAR(255) NOT NULL,
            holder_id INT NOT NULL,
            start_time DATETIME NOT NULL,
            end_time DATETIME NOT NULL,
            booker_id INT,
            booker_note VARCHAR(255),
            status TINYINT NOT NULL,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            la_booked TINYINT(4) NOT NULL DEFAULT 0,
            FOREIGN KEY (course_id) REFERENCES courses(id),
            FOREIGN KEY (holder_id) REFERENCES users(id),
            FOREIGN KEY (booker_id) REFERENCES users(id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE bookings;";
        $db->pdo->exec($SQL);
    }
}