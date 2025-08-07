<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'u474266573_gms';
    private $username = 'u474266573_user_gms';
    private $password = 'Z;cc#>0h6|Nt';
    private $connection = null;
    private $error_log_file = "public/logs/error_logs.txt";

    public function __construct()
    {
        $this->make_error_logs_directory();

        $this->connect();
        $this->create_database();
        $this->select_database();
        $this->create_users_table();
        $this->create_strands_table();
        $this->create_students_table();
        $this->create_subjects_table();
        $this->create_grades_table();
        $this->create_logs_table();
        $this->insert_admin_data();
    }

    private function make_error_logs_directory()
    {
        if (!file_exists($this->error_log_file)) {
            $log_dir = dirname($this->error_log_file);
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0755, true);
            }
            file_put_contents($this->error_log_file, '');
        }
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
            lrn VARCHAR(12) NOT NULL UNIQUE,
            strand_id INT(11) NOT NULL,
            grade_level ENUM('11', '12') NOT NULL,
            section VARCHAR(20) NOT NULL,
            first_name VARCHAR(50) NOT NULL,
            middle_name VARCHAR(50),
            last_name VARCHAR(50) NOT NULL,
            birthday DATE NOT NULL,
            sex ENUM('Male', 'Female') NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            address VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            FOREIGN KEY (strand_id) REFERENCES strands(id)
                ON DELETE RESTRICT
                ON UPDATE CASCADE,
            FOREIGN KEY (account_id) REFERENCES users(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating students table: " . $this->connection->error);
        }
    }

    private function create_strands_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS strands (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            code VARCHAR(10) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating strands table: " . $this->connection->error);
        }
    }

    private function create_subjects_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS subjects (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            category ENUM('core', 'applied and specialized') NOT NULL,
            grade_level ENUM('11', '12'),
            strand_id INT(11),
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            FOREIGN KEY (strand_id) REFERENCES strands(id)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating subjects table: " . $this->connection->error);
        }
    }

    private function create_grades_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS grades (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) NOT NULL UNIQUE,
            student_id INT(11) NOT NULL,
            subject_id INT(11) NOT NULL,
            quarter_1 DECIMAL(5,2),
            quarter_2 DECIMAL(5,2),
            quarter_3 DECIMAL(5,2),
            quarter_4 DECIMAL(5,2),
            final_grade DECIMAL(5,2),
            remarks VARCHAR(20),
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            UNIQUE(student_id, subject_id), -- Prevent duplicate entries for the same subject
            FOREIGN KEY (student_id) REFERENCES students(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            FOREIGN KEY (subject_id) REFERENCES subjects(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        )";

        if (!$this->connection->query($sql) === TRUE) {
            die("Error creating grades table: " . $this->connection->error);
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

    /**
     * Gets the last inserted ID.
     *
     * @return int
     */
    public function get_last_insert_id()
    {
        return $this->connection->insert_id;
    }

    /**
     * Selects a single row from a table based on a condition.
     *
     * @param string $table
     * @param string $condition_column
     * @param mixed $condition_value
     * @return array|null
     */
    public function select_one($table, $condition_column, $condition_value)
    {
        $sql = "SELECT * FROM $table WHERE $condition_column = ? LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $condition_value);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Selects multiple rows from a table based on a condition or custom SQL.
     *
     * @param string|null $table
     * @param string|null $condition_column
     * @param mixed|null $condition_value
     * @param string|null $order_by
     * @param string $direction
     * @param string|null $custom_sql
     * @return array
     */
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

    /**
     * Selects all rows from a table, optionally ordered.
     *
     * @param string $table
     * @param string|null $order_by
     * @param string $direction
     * @return array
     */
    public function select_all($table, $order_by = null, $direction = 'ASC')
    {
        $sql = "SELECT * FROM $table";

        if ($order_by) {
            $sql .= " ORDER BY $order_by " . strtoupper($direction);
        }

        $result = $this->connection->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Inserts a row into a table.
     *
     * @param string $table
     * @param array $data
     * @return bool
     */
    public function insert($table, $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Prepare failed: " . $this->connection->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }

            $types = $this->getParamTypes($data);
            $values = array_values($data);

            if ($stmt->bind_param($types, ...$values) && $stmt->execute()) {
                return true;
            } else {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Bind/Execute failed: " . $stmt->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            $error_message = "[" . date("Y-m-d H:i:s") . "] Exception: " . $e->getMessage() . PHP_EOL;
            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
            return false;
        }
    }

    /**
     * Updates a row in a table.
     *
     * @param string $table
     * @param array $data
     * @param string $condition_column
     * @param mixed $condition_value
     * @return bool
     */
    public function update($table, $data, $condition_column, $condition_value)
    {
        try {
            $set = implode(", ", array_map(function ($key) {
                return "$key = ?";
            }, array_keys($data)));

            $sql = "UPDATE $table SET $set WHERE $condition_column = ?";
            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Update Prepare failed: " . $this->connection->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }

            $types = $this->getParamTypes($data);
            $values = array_values($data);
            $types .= is_int($condition_value) ? 'i' : 's';

            if (!$stmt->bind_param($types, ...array_merge($values, [$condition_value]))) {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Update Bind failed: " . $stmt->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }

            if ($stmt->execute()) {
                return true;
            } else {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Update Execute failed: " . $stmt->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            $error_message = "[" . date("Y-m-d H:i:s") . "] Update Exception: " . $e->getMessage() . PHP_EOL;
            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
            return false;
        }
    }

    /**
     * Deletes a row from a table.
     *
     * @param string $table
     * @param string $condition_column
     * @param mixed $condition_value
     * @return bool
     */
    public function delete($table, $condition_column, $condition_value)
    {
        try {
            $sql = "DELETE FROM $table WHERE $condition_column = ?";
            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Delete Prepare failed: " . $this->connection->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }

            $type = is_int($condition_value) ? 'i' : 's';

            if (!$stmt->bind_param($type, $condition_value)) {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Delete Bind failed: " . $stmt->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }

            if ($stmt->execute()) {
                return true;
            } else {
                $error_message = "[" . date("Y-m-d H:i:s") . "] Delete Execute failed: " . $stmt->error . PHP_EOL;
                file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            $error_message = "[" . date("Y-m-d H:i:s") . "] Delete Exception: " . $e->getMessage() . PHP_EOL;
            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
            return false;
        }
    }

    /**
     * Checks if all subjects for a teacher have a total weight of 100 in grade_components.
     *
     * @param int $teacher_id
     * @return bool
     */
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

    /**
     * Runs a custom SQL query (SELECT, INSERT, DROP, etc.) and returns result if applicable.
     *
     * @param string $custom_sql
     * @return array|bool Returns result array for SELECT, true for successful non-SELECT, false on failure.
     */
    public function run_custom_query($custom_sql)
    {
        $stmt = $this->connection->prepare($custom_sql);

        if (!$stmt) {
            return false;
        }

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return true;
    }

    /**
     * Drops all tables in the database.
     *
     * @return void
     */
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

    /**
     * Creates a backup of the database structure and data.
     *
     * @param string|null $backupDir Directory to save backup file.
     * @return string|null Path to the backup file, or null if failed.
     */
    public function backup($backupDir = null)
    {
        $backupDir = $backupDir ?? __DIR__;
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

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

            $sqlDump = "-- Database Backup\n";
            $sqlDump .= "-- Database: `{$this->dbname}`\n";
            $sqlDump .= "-- Date: " . date("Y-m-d H:i:s") . "\n\n";
            $sqlDump .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

            foreach ($tables as $table) {
                // Drop table if exists
                $sqlDump .= "-- ----------------------------\n";
                $sqlDump .= "-- Structure for table `$table`\n";
                $sqlDump .= "-- ----------------------------\n";
                $sqlDump .= "DROP TABLE IF EXISTS `$table`;\n";

                // Table structure
                $createTable = $this->connection->query("SHOW CREATE TABLE `$table`");
                if ($createTable) {
                    $row = $createTable->fetch_row();
                    $sqlDump .= $row[1] . ";\n\n";
                }

                // Table data
                $dataResult = $this->connection->query("SELECT * FROM `$table`");
                if ($dataResult && $dataResult->num_rows > 0) {
                    $sqlDump .= "-- ----------------------------\n";
                    $sqlDump .= "-- Data for table `$table`\n";
                    $sqlDump .= "-- ----------------------------\n";

                    while ($row = $dataResult->fetch_assoc()) {
                        $columns = array_map(function ($col) {
                            return "`$col`";
                        }, array_keys($row));

                        $values = array_map(function ($value) {
                            if (is_null($value)) {
                                return "NULL";
                            }
                            return "'" . addslashes($value) . "'";
                        }, array_values($row));

                        $sqlDump .= "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
                    }

                    $sqlDump .= "\n";
                }
            }

            $sqlDump .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            if (file_put_contents($backupFile, $sqlDump) === false) {
                throw new Exception("Error writing to backup file.");
            }

            return $backupFile;
        } catch (Exception $e) {
            $error_message = date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n";
            file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
            return null;
        }
    }

    /**
     * Restores the database from a backup file using pre-defined helper methods.
     *
     * @param string $file_path Path to the backup file.
     * @return bool
     */
    public function restore($file_path)
    {
        if (!file_exists($file_path)) {
            file_put_contents($this->error_log_file, "Backup file does not exist: $file_path" . PHP_EOL, FILE_APPEND);
            return false;
        }

        try {
            // Disable foreign key checks
            $this->run_custom_query("SET FOREIGN_KEY_CHECKS = 0");

            // Drop all existing tables
            $this->drop_all_tables();

            // Re-enable foreign key checks before restore
            $this->run_custom_query("SET FOREIGN_KEY_CHECKS = 1");

            // Read and clean SQL file
            $sqlContent = file_get_contents($file_path);
            $sqlContent = preg_replace('/--.*(\r?\n)/', '', $sqlContent);     // Remove -- comments
            $sqlContent = preg_replace('/\/\*.*?\*\//s', '', $sqlContent);    // Remove /* */ comments

            // Split SQL into individual statements
            $queries = array_filter(array_map('trim', explode(";\n", $sqlContent)));

            // Execute each query
            foreach ($queries as $query) {
                if (!empty($query)) {
                    $result = $this->run_custom_query($query);
                    if ($result === false) {
                        $error_message = "Error executing query: $query" . PHP_EOL;
                        file_put_contents($this->error_log_file, $error_message, FILE_APPEND);
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            file_put_contents($this->error_log_file, "Restore failed: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
            return false;
        }
    }
}
