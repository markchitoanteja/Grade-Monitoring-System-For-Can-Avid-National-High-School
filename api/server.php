<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_datetime = date("Y-m-d H:i:s");

    $db = new Database();

    function upload_image($target_directory, $image_file)
    {
        $response = false;

        if (isset($image_file) && $image_file['error'] == UPLOAD_ERR_OK) {
            $uploadedFile = $image_file;

            $target_dir = $target_directory;

            if ($uploadedFile['size'] > 0) {
                $file_temp = $uploadedFile['tmp_name'];
                $file_ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

                $unique_name = uniqid('img_', true) . '.' . $file_ext;

                if (move_uploaded_file($file_temp, $target_dir . '/' . $unique_name)) {
                    $response = $unique_name;
                }
            }
        }

        return $response;
    }

    function generate_uuid()
    {
        return bin2hex(random_bytes(16));
    }

    function insert_log($user_id, $activity)
    {
        $db = new Database();

        $data = [
            "uuid" => generate_uuid(),
            "user_id" => $user_id,
            "activity" => $activity,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ];

        return $db->insert("logs", $data);
    }

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $remember_me = $_POST["remember_me"];

        $response = false;

        $user = $db->select_one('users', 'username', $username);

        if ($user) {
            $hashed_password = $user["password"];

            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_type"] = $user["user_type"];

                if ($remember_me == "true") {
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                } else {
                    unset($_SESSION["username"]);
                    unset($_SESSION["password"]);
                }

                insert_log($_SESSION["user_id"], "Successfully logged into the system.");

                $response = true;
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["get_admin_data"])) {
        $user_id = $_POST["user_id"];

        $user_data = $db->select_one("users", "id", $user_id);

        echo json_encode($user_data);
    }

    if (isset($_POST["update_admin_account"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $image_file = isset($_FILES["image_file"]) ? $_FILES["image_file"] : null;
        $old_password = $_POST["old_password"];
        $old_image = $_POST["old_image"];
        $is_new_password = $_POST["is_new_password"];
        $is_new_image = $_POST["is_new_image"];

        $response = false;

        if ($is_new_password == "true") {
            $password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $password = $old_password;
        }

        if ($is_new_image == "true") {
            $image = upload_image("public/assets/img/uploads/", $image_file);
        } else {
            $image = $old_image;
        }

        $data = [
            "name" => $name,
            "username" => $username,
            "password" => $password,
            "image" => $image,
            "updated_at" => $current_datetime,
        ];

        if ($db->update("users", $data, "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "The admin data has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "The admin data has been updated successfully.");

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["get_strand_data"])) {
        $id = $_POST["id"];

        $response = false;

        $strand_data = $db->select_one("strands", "id", $id);

        if ($strand_data) {
            $response = [
                "id" => $strand_data["id"],
                "code" => $strand_data["code"],
                "name" => $strand_data["name"],
                "description" => $strand_data["description"],
            ];
        }

        echo json_encode($response);
    }

    if (isset($_POST["new_strand"])) {
        $code = $_POST["code"];
        $name = $_POST["name"];
        $description = $_POST["description"];

        $response = false;

        if (!$db->select_one("strands", "code", $code)) {
            $data = [
                "uuid" => generate_uuid(),
                "code" => $code,
                "name" => $name,
                "description" => $description,
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            if ($db->insert("strands", $data)) {
                $_SESSION["notification"] = [
                    "title" => "Success!",
                    "text" => "A new strand has been added successfully.",
                    "icon" => "success",
                ];

                insert_log($_SESSION["user_id"], "A new strand has been added successfully.");

                $response = true;
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_strand"])) {
        $id = $_POST["id"];
        $code = $_POST["code"];
        $name = $_POST["name"];
        $description = $_POST["description"];

        $response = false;

        $data = [
            "code" => $code,
            "name" => $name,
            "description" => $description,
            "updated_at" => $current_datetime,
        ];

        if ($db->update("strands", $data, "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A strand has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A strand has been updated successfully.");

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_strand"])) {
        $id = $_POST["id"];

        $response = false;

        if ($db->delete("strands", "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A strand has been deleted successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A strand has been deleted successfully.");

            $response = true;
        } else {
            $_SESSION["notification"] = [
                "title" => "Oops...",
                "text" => "Failed to delete the strand.",
                "icon" => "error",
            ];

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["get_student_data"])) {
        $account_id = $_POST["account_id"];

        $student_data = $db->select_one("students", "account_id", $account_id);
        $image = $db->select_one("users", "id", $account_id)["image"];

        $student_data["image"] = $image;

        echo json_encode($student_data);
    }

    if (isset($_POST["new_student"])) {
        $lrn = $_POST["lrn"];
        $strand_id = $_POST["strand_id"];
        $grade_level = $_POST["grade_level"];
        $section = $_POST["section"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $sex = $_POST["sex"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = isset($_FILES["image_file"]) ? $_FILES["image_file"] : null;

        $response = [
            "lrn_ok" => true,
            "email_ok" => true,
        ];

        $is_error = false;

        if ($db->select_one("students", "lrn", $lrn)) {
            $response["lrn_ok"] = false;

            $is_error = true;
        }

        if ($db->select_one("students", "email", $email)) {
            $response["email_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            if ($image_file) {
                $image = upload_image("public/assets/img/uploads/", $image_file);
            } else {
                $image = "default-user-image.png";
            }

            $user_data = [
                "uuid" => generate_uuid(),
                "name" => $name,
                "username" => $lrn,
                "password" => password_hash($lrn, PASSWORD_BCRYPT),
                "image" => $image,
                "user_type" => "student",
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->insert("users", $user_data);

            $account_id = $db->get_last_insert_id();

            $teacher_data = [
                "uuid" => generate_uuid(),
                "account_id" => $account_id,
                "lrn" => $lrn,
                "strand_id" => $strand_id,
                "grade_level" => $grade_level,
                "section" => $section,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "sex" => $sex,
                "email" => $email,
                "address" => $address,
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->insert("students", $teacher_data);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A student has been added successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A student has been added successfully.");
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_student"])) {
        $account_id = $_POST["account_id"];
        $old_image = $_POST["old_image"];
        $lrn = $_POST["lrn"];
        $strand_id = $_POST["strand_id"];
        $grade_level = $_POST["grade_level"];
        $section = $_POST["section"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $sex = $_POST["sex"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = isset($_FILES["image_file"]) ? $_FILES["image_file"] : null;

        $response = [
            "lrn_ok" => true,
            "email_ok" => true,
        ];

        $is_error = false;

        if ($db->run_custom_query("SELECT id FROM students WHERE lrn = '$lrn' AND account_id != '$account_id'")) {
            $response["lrn_ok"] = false;

            $is_error = true;
        }

        if ($db->run_custom_query("SELECT id FROM students WHERE email = '$email' AND account_id != '$account_id'")) {
            $response["email_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            if ($image_file) {
                $image = upload_image("public/assets/img/uploads/", $image_file);
            } else {
                $image = $old_image;
            }

            $user_data = [
                "name" => $name,
                "image" => $image,
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->update("users", $user_data, "id", $account_id);

            $students_data = [
                "lrn" => $lrn,
                "strand_id" => $strand_id,
                "grade_level" => $grade_level,
                "section" => $section,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "sex" => $sex,
                "email" => $email,
                "address" => $address,
                "updated_at" => $current_datetime,
            ];

            $db->update("students", $students_data, "account_id", $account_id);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A student has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A student has been updated successfully.");
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_student"])) {
        $account_id = $_POST["account_id"];

        $response = false;

        if ($db->delete("students", "account_id", $account_id)) {
            $db->delete("users", "id", $account_id);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A student has been deleted successfully.",
                "icon" => "success",
            ];

            $response = true;

            insert_log($_SESSION["user_id"], "A student has been deleted successfully.");
        }

        echo json_encode($response);
    }

    if (isset($_POST["get_subject_data"])) {
        $id = $_POST["id"];

        $response = $db->select_one("subjects", "id", $id);

        echo json_encode($response);
    }

    if (isset($_POST["new_subject"])) {
        $name = $_POST["name"];
        $category = $_POST["category"];
        $grade_level = $_POST["grade_level"];
        $strand_id = $_POST["strand_id"];

        $response = false;

        if (strtolower($strand_id) === "0") {
            $strands = $db->select_all("strands");

            if (!empty($strands)) {
                $successCount = 0;

                foreach ($strands as $strand) {
                    $s_id = $strand["id"];

                    if (!$db->run_custom_query("SELECT id FROM subjects WHERE name='$name' AND category='$category' AND grade_level='$grade_level' AND strand_id='$s_id'")) {
                        $data = [
                            "uuid" => generate_uuid(),
                            "name" => $name,
                            "category" => $category,
                            "grade_level" => $grade_level,
                            "strand_id" => $s_id,
                            "created_at" => $current_datetime,
                            "updated_at" => $current_datetime
                        ];

                        if ($db->insert("subjects", $data)) {
                            $successCount++;
                        }
                    }
                }

                if ($successCount > 0) {
                    $_SESSION["notification"] = [
                        "title" => "Success!",
                        "text" => "Successfully added $successCount subjects.",
                        "icon" => "success",
                    ];

                    insert_log($_SESSION["user_id"], "Added $successCount subjects.");

                    $response = true;
                } else {
                    $_SESSION["notification"] = [
                        "title" => "Information",
                        "text" => "No subject is added.",
                        "icon" => "info",
                    ];

                    $response = true;
                }
            }
        } else {
            if (!$db->run_custom_query("SELECT id FROM subjects WHERE name='$name' AND category='$category' AND grade_level='$grade_level' AND strand_id='$strand_id'")) {
                $data = [
                    "uuid" => generate_uuid(),
                    "name" => $name,
                    "category" => $category,
                    "grade_level" => $grade_level,
                    "strand_id" => $strand_id,
                    "created_at" => $current_datetime,
                    "updated_at" => $current_datetime
                ];

                if ($db->insert("subjects", $data)) {
                    $_SESSION["notification"] = [
                        "title" => "Success!",
                        "text" => "A new subject has been added successfully.",
                        "icon" => "success",
                    ];

                    insert_log($_SESSION["user_id"], "A new subject has been added successfully.");

                    $response = true;
                }
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_subject"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $category = $_POST["category"];
        $grade_level = $_POST["grade_level"];
        $strand_id = $_POST["strand_id"];

        $response = false;

        if (!$db->run_custom_query("SELECT id FROM subjects WHERE name='$name' AND category='$category' AND grade_level='$grade_level' AND strand_id='$strand_id' AND id != '$id'")) {
            $data = [
                "name" => $name,
                "category" => $category,
                "grade_level" => $grade_level,
                "strand_id" => $strand_id,
                "updated_at" => $current_datetime
            ];

            if ($db->update("subjects", $data, "id", $id)) {
                $_SESSION["notification"] = [
                    "title" => "Success!",
                    "text" => "A new subject has been updated successfully.",
                    "icon" => "success",
                ];

                insert_log($_SESSION["user_id"], "A new subject has been updated successfully.");

                $response = true;
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_subject"])) {
        $id = $_POST["id"];

        $response = false;

        if ($db->delete("subjects", "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A subject has been deleted successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A subject has been deleted successfully.");

            $response = true;
        } else {
            $_SESSION["notification"] = [
                "title" => "Oops...",
                "text" => "Failed to delete the subject.",
                "icon" => "error",
            ];

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["backup_database"])) {
        $backup = $db->backup("public/backup");

        if ($backup) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "Database backup was successful.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "Database backup was successful.");
        }

        echo json_encode(true);
    }

    if (isset($_POST["restore_database"])) {
        $backup_file = basename($_POST["backup_file"]);
        $backup_dir = 'public/backup/';
        $file_path = $backup_dir . $backup_file;

        if (!file_exists($file_path)) {
            $_SESSION["notification"] = [
                "title" => "Oops..",
                "text" => "The backup file does not exists!",
                "icon" => "error",
            ];
        } else {
            if ($db->restore($file_path)) {
                $_SESSION["notification"] = [
                    "title" => "Success!",
                    "text" => "Database restored successfully from $backup_file.",
                    "icon" => "success",
                ];

                insert_log($_SESSION["user_id"], 'Restored database from backup file: ' . $backup_file);
            } else {
                $_SESSION["notification"] = [
                    "title" => "Oops..",
                    "text" => "There was an error while processing your request.",
                    "icon" => "error",
                ];
            }
        }

        echo json_encode(true);
    }

    if (isset($_POST["logout"])) {
        insert_log($_SESSION["user_id"], "Logged out successfully.");

        unset($_SESSION["user_id"]);

        $_SESSION["notification"] = [
            "type" => "alert-success bg-success",
            "message" => "You have been logged out.",
        ];

        echo json_encode(true);
    }
} else {
    http_response_code(404);

    header("Location: " . base_url("404.php"));
}
