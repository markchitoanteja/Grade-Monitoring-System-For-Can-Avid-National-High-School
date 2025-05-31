<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'u474266573_gms';
    private $username = 'u474266573_user_gms';
    private $password = 'Z;cc#>0h6|Nt';
    private $connection;
    private $error_log_file = "logs/error_logs.txt";

    public function __construct()
    {
        $this->connect();
        $this->create_database();
        $this->select_database();
        $this->create_users_table();
        $this->create_students_table();
        $this->create_teachers_table();
        $this->create_courses_table();
        $this->create_subjects_table();
        $this->create_student_grades_table();
        $this->create_grade_components_table();
        $this->create_logs_table();
        $this->insert_admin_data();
    }

    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function create_database()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating database: " . $this->connection->error);
        }
    }

    private function select_database()
    {
        $this->connection->select_db($this->dbname);
    }

    private function create_users_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            image VARCHAR(50) NOT NULL,
            user_type VARCHAR(20) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_students_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS students (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            account_id INT(11) NOT NULL UNIQUE,
            student_number VARCHAR(100) NOT NULL UNIQUE,
            course VARCHAR(100) NOT NULL,
            year VARCHAR(100) NOT NULL,
            section VARCHAR(100) NOT NULL,
            first_name VARCHAR(100) NOT NULL,
            middle_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            birthday VARCHAR(100) NOT NULL,
            mobile_number VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            address TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_teachers_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS teachers (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            account_id INT(11) NOT NULL UNIQUE,
            employee_number VARCHAR(100) NOT NULL UNIQUE,
            first_name VARCHAR(100) NOT NULL,
            middle_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            birthday VARCHAR(100) NOT NULL,
            mobile_number VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            address TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_courses_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS courses (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            code VARCHAR(100) NOT NULL UNIQUE,
            description VARCHAR(100) NOT NULL,
            years INT(11) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_grade_components_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS grade_components (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            teacher_id INT(11) NOT NULL,
            subject_id INT(11) NOT NULL,
            component VARCHAR(255) NOT NULL,
            weight INT(11) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_student_grades_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS student_grades (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            teacher_id INT(11) NOT NULL,
            student_id INT(11) NOT NULL,
            subject_id INT(11) NOT NULL,
            grade_component_id INT(11) NOT NULL,
            course VARCHAR(100) NOT NULL,
            year VARCHAR(10) NOT NULL,
            semester VARCHAR(10) NOT NULL,
            grade FLOAT(11,2) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_subjects_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS subjects (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            code VARCHAR(100) NOT NULL,
            description VARCHAR(100) NOT NULL,
            lecture_units INT(11) NOT NULL,
            laboratory_units INT(11) NOT NULL,
            hours_per_week INT(11) NOT NULL,
            course VARCHAR(100) NOT NULL,
            year VARCHAR(10) NOT NULL,
            semester VARCHAR(10) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function create_logs_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS logs (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            user_id INT(11) NOT NULL,
            activity TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating users table: " . $this->connection->error);
        }
    }

    private function insert_admin_data()
    {
        $is_admin_exists = $this->select_one("users", "id", "1");

        if (!$is_admin_exists) {
            $data = [
                "uuid" => $this->generate_uuid(),
                "name" => 'Administrator',
                "username" => 'admin',
                "password" => password_hash('admin123', PASSWORD_BCRYPT),
                "image" => 'default-user-image.png',
                "user_type" => 'admin',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];

            $this->insert("users", $data);
        }
    }

    private function generate_uuid()
    {
        return bin2hex(random_bytes(16));
    }

    private function getParamTypes($data)
    {
        return implode('', array_map(function ($value) {
            return is_int($value) ? 'i' : (is_double($value) ? 'd' : 's');
        }, $data));
    }

    public function get_last_insert_id()
    {
        return $this->connection->insert_id;
    }

    public function select_one($table, $condition_column, $condition_value)
    {
        $sql = "SELECT * FROM $table WHERE $condition_column = ? LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $condition_value);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function select_many($table = null, $condition_column = null, $condition_value = null, $order_by = null, $direction = 'ASC', $custom_sql = null)
    {
        if ($custom_sql) {
            $stmt = $this->connection->prepare($custom_sql);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        $sql = "SELECT * FROM $table WHERE $condition_column = ?";

        if ($order_by) {
            $sql .= " ORDER BY $order_by " . strtoupper($direction);
        }

        $stmt = $this->connection->prepare($sql);

        $type = is_int($condition_value) ? 'i' : 's';
        $stmt->bind_param($type, $condition_value);

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function select_all($table, $order_by = null, $direction = 'ASC')
    {
        $sql = "SELECT * FROM $table";

        if ($order_by) {
            $sql .= " ORDER BY $order_by " . strtoupper($direction);
        }

        $result = $this->connection->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($table, $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);

            $types = $this->getParamTypes($data);
            $values = array_values($data);

            if ($stmt->bind_param($types, ...$values) && $stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function update($table, $data, $condition_column, $condition_value)
    {
        try {
            $set = implode(", ", array_map(function ($key) {
                return "$key = ?";
            }, array_keys($data)));

            $sql = "UPDATE $table SET $set WHERE $condition_column = ?";
            $stmt = $this->connection->prepare($sql);

            $types = $this->getParamTypes($data);
            $values = array_values($data);
            $types .= is_int($condition_value) ? 'i' : 's';

            $stmt->bind_param($types, ...array_merge($values, [$condition_value]));

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function delete($table, $condition_column, $condition_value)
    {
        try {
            $sql = "DELETE FROM $table WHERE $condition_column = ?";
            $stmt = $this->connection->prepare($sql);

            $type = is_int($condition_value) ? 'i' : 's';
            $stmt->bind_param($type, $condition_value);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function check_subject_weight($teacher_id)
    {
        $sql = "SELECT subject_id, SUM(weight) as total_weight 
            FROM grade_components 
            WHERE teacher_id = ? 
            GROUP BY subject_id 
            HAVING total_weight = 100";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('i', $teacher_id);

        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function run_custom_query($custom_sql)
    {
        $stmt = $this->connection->prepare($custom_sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function drop_all_tables()
    {
        $result = $this->connection->query("SHOW TABLES");

        if (!$result) {
            $error_message = "Error fetching tables: " . $this->connection->error;

            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);

            return;
        }

        while ($row = $result->fetch_row()) {
            $table = $row[0];

            $dropTableQuery = "DROP TABLE IF EXISTS `$table`";

            if (!$this->connection->query($dropTableQuery)) {
                $error_message = "Error dropping table '$table': " . $this->connection->error;

                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
            }
        }
    }

    public function backup($backupDir = null)
    {
        $backupDir = $backupDir ?? __DIR__;
        $backupFile = $backupDir . '/backup_' . $this->dbname . '_' . date("Y-m-d_H-i-s") . '.sql';

        try {
            $tables = [];
            $result = $this->connection->query("SHOW TABLES");

            if (!$result) {
                throw new Exception("Error retrieving tables: " . $this->connection->error);
            }

            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }

            $sqlDump = "-- Database Backup\n-- Database: {$this->dbname}\n-- Date: " . date("Y-m-d H:i:s") . "\n\n";

            foreach ($tables as $table) {
                $tableCreate = $this->connection->query("SHOW CREATE TABLE `$table`")->fetch_row()[1] . ";\n\n";
                $sqlDump .= "-- Structure for table `$table`\n";
                $sqlDump .= $tableCreate . "\n\n";

                $result = $this->connection->query("SELECT * FROM `$table`");

                if ($result->num_rows > 0) {
                    $sqlDump .= "-- Data for table `$table`\n";
                    while ($row = $result->fetch_assoc()) {
                        $values = array_map([$this->connection, 'real_escape_string'], array_values($row));
                        $values = "'" . implode("', '", $values) . "'";
                        $columns = implode("`, `", array_keys($row));
                        $sqlDump .= "INSERT INTO `$table` (`$columns`) VALUES ($values);\n";
                    }
                    $sqlDump .= "\n";
                }
            }

            if (file_put_contents($backupFile, $sqlDump) === false) {
                throw new Exception("Error writing backup file");
            }

            return $backupFile;
        } catch (Exception $e) {
            $error_message = date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n";

            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
        }
    }

    public function restore($file_path)
    {
        if (file_exists($file_path)) {
            $this->drop_all_tables();

            $fp = fopen($file_path, 'r');
            $fetchData = fread($fp, filesize($file_path));
            fclose($fp);

            $sqlInfo = explode(";\n", $fetchData);

            foreach ($sqlInfo as $sqlData) {
                $sqlData = trim($sqlData);

                if (!empty($sqlData)) {
                    try {
                        $stmt = $this->connection->prepare($sqlData);
                        if ($stmt) {
                            $stmt->execute();
                        } else {
                            $error_message = "Failed to prepare statement: " . $this->connection->error;

                            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                        }
                    } catch (mysqli_sql_exception $e) {
                        $error_message = "Error executing query: " . $e->getMessage();

                        file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                    }
                }
            }

            $this->connection->commit();

            return true;
        } else {
            file_put_contents($this->error_log_file, "Backup file does not exist: " . $file_path, FILE_APPEND);

            return false;
        }
    }
}

$db = new Database();
