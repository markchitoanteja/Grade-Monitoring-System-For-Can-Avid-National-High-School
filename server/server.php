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

    if (isset($_POST["get_course_data"])) {
        $id = $_POST["id"];

        $course_data = $db->select_one("courses", "id", $id);

        echo json_encode($course_data);
    }

    if (isset($_POST["get_course_data_by_code"])) {
        $code = $_POST["code"];

        $course_data = $db->select_one("courses", "code", $code);

        echo json_encode($course_data);
    }

    if (isset($_POST["get_student_data_by_account_id"])) {
        $account_id = $_POST["account_id"];

        $student_data = $db->select_one("students", "account_id", $account_id);

        echo json_encode($student_data);
    }

    if (isset($_POST["get_subjects"])) {
        $course = $_POST["course"];
        $year = $_POST["year"];
        $semester = $_POST["semester"];

        $sql = "SELECT id, description FROM subjects WHERE course='" . $course . "' AND year='" . $year . "' AND semester='" . $semester . "'";
        $subjects = $db->select_many(null, null, null, null, null, $sql);

        echo json_encode($subjects);
    }

    if (isset($_POST["get_subject_data"])) {
        $id = $_POST["id"];

        $subject_data = $db->select_one("subjects", "id", $id);

        echo json_encode($subject_data);
    }

    if (isset($_POST["get_teacher_data"])) {
        $id = $_POST["id"];

        $user_data = $db->select_one("users", "id", $id);
        $teacher_data = $db->select_one("teachers", "account_id", $id);

        echo json_encode(array_merge($user_data, $teacher_data));
    }

    if (isset($_POST["get_student_data"])) {
        $id = $_POST["id"];

        $user_data = $db->select_one("users", "id", $id);
        $student_data = $db->select_one("students", "account_id", $id);

        echo json_encode(array_merge($user_data, $student_data));
    }

    if (isset($_POST["get_grade_component_data"])) {
        $id = $_POST["id"];

        $grade_component_data = $db->select_one("grade_components", "id", $id);

        echo json_encode($grade_component_data);
    }

    if (isset($_POST["get_grade_component_data_by_teacher_id_and_subject_id"])) {
        $teacher_id = $_POST["teacher_id"];
        $subject_id = $_POST["subject_id"];

        $sql = "SELECT * FROM grade_components WHERE teacher_id='" . $teacher_id . "' AND subject_id='" . $subject_id . "'";
        $grade_component_data = $db->run_custom_query($sql);

        echo json_encode($grade_component_data);
    }

    if (isset($_POST["get_student_grade_data"])) {
        $id = $_POST["id"];

        $student_grade_data = $db->select_one("student_grades", "id", $id);

        echo json_encode($student_grade_data);
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
            $image = upload_image("assets/img/uploads/", $image_file);
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

    if (isset($_POST["new_course"])) {
        $code = $_POST["code"];
        $description = $_POST["description"];
        $years = $_POST["years"];

        $response = false;

        $data = [
            "uuid" => generate_uuid(),
            "code" => $code,
            "description" => $description,
            "years" => $years,
            "created_at" => $current_datetime,
            "updated_at" => $current_datetime,
        ];

        if ($db->insert("courses", $data)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A course has been added successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A course has been added successfully.");

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_course"])) {
        $id = $_POST["id"];
        $code = $_POST["code"];
        $description = $_POST["description"];
        $years = $_POST["years"];

        $response = false;

        $data = [
            "code" => $code,
            "description" => $description,
            "years" => $years,
            "updated_at" => $current_datetime,
        ];

        if ($db->update("courses", $data, "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A course has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A course has been updated successfully.");

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_course"])) {
        $id = $_POST["id"];

        $db->delete("courses", "id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A course has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A course has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["new_subject"])) {
        $code = $_POST["code"];
        $description = $_POST["description"];
        $lecture_units = $_POST["lecture_units"];
        $laboratory_units = $_POST["laboratory_units"];
        $hours_per_week = $_POST["hours_per_week"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $semester = $_POST["semester"];

        $response = false;

        $data = [
            "uuid" => generate_uuid(),
            "code" => $code,
            "description" => $description,
            "lecture_units" => $lecture_units,
            "laboratory_units" => $laboratory_units,
            "hours_per_week" => $hours_per_week,
            "course" => $course,
            "year" => $year,
            "semester" => $semester,
            "created_at" => $current_datetime,
            "updated_at" => $current_datetime,
        ];

        if ($db->insert("subjects", $data)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A subject has been added successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A subject has been added successfully.");

            $response = true;
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_subject"])) {
        $id = $_POST["id"];
        $code = $_POST["code"];
        $description = $_POST["description"];
        $lecture_units = $_POST["lecture_units"];
        $laboratory_units = $_POST["laboratory_units"];
        $hours_per_week = $_POST["hours_per_week"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $semester = $_POST["semester"];

        $response = false;

        $data = [
            "code" => $code,
            "description" => $description,
            "lecture_units" => $lecture_units,
            "laboratory_units" => $laboratory_units,
            "hours_per_week" => $hours_per_week,
            "course" => $course,
            "year" => $year,
            "semester" => $semester,
            "updated_at" => $current_datetime,
        ];

        if ($db->update("subjects", $data, "id", $id)) {
            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A subject has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A subject has been updated successfully.");

            $response = true;
        }

        echo json_encode($data);
    }

    if (isset($_POST["delete_subject"])) {
        $id = $_POST["id"];

        $db->delete("subjects", "id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A subject has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A subject has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["new_teacher"])) {
        $employee_number = $_POST["employee_number"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $mobile_number = $_POST["mobile_number"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = $_FILES["image_file"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $response = [
            "employee_number_ok" => true,
            "username_ok" => true,
        ];

        $is_error = false;

        if ($db->select_one("teachers", "employee_number", $employee_number)) {
            $response["employee_number_ok"] = false;

            $is_error = true;
        }

        if ($db->select_one("users", "username", $username)) {
            $response["username_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            $image = upload_image("assets/img/uploads/", $image_file);

            $user_data = [
                "uuid" => generate_uuid(),
                "name" => $name,
                "username" => $username,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "image" => $image,
                "user_type" => "teacher",
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->insert("users", $user_data);

            $account_id = $db->get_last_insert_id();

            $teacher_data = [
                "uuid" => generate_uuid(),
                "account_id" => $account_id,
                "employee_number" => $employee_number,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "mobile_number" => $mobile_number,
                "email" => $email,
                "address" => $address,
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->insert("teachers", $teacher_data);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A teacher has been added successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A teacher has been added successfully.");
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_teacher"])) {
        $employee_number = $_POST["employee_number"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $mobile_number = $_POST["mobile_number"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = isset($_FILES["image_file"]) ? $_FILES["image_file"] : null;
        $username = $_POST["username"];
        $password = $_POST["password"];

        $account_id = $_POST["account_id"];
        $old_image = $_POST["old_image"];
        $old_password = $_POST["old_password"];
        $old_employee_number = $_POST["old_employee_number"];
        $old_username = $_POST["old_username"];

        $is_new_image = $_POST["is_new_image"];
        $is_new_password = $_POST["is_new_password"];

        $response = [
            "employee_number_ok" => true,
            "username_ok" => true,
        ];

        $is_error = false;

        if (($employee_number != $old_employee_number) && ($db->select_one("teachers", "employee_number", $employee_number))) {
            $response["employee_number_ok"] = false;

            $is_error = true;
        }

        if (($username != $old_username) && ($db->select_one("users", "username", $username))) {
            $response["username_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            if ($is_new_image == "true") {
                $image = upload_image("assets/img/uploads/", $image_file);
            } else {
                $image = $old_image;
            }

            if ($is_new_password == "true") {
                $password = password_hash($password, PASSWORD_BCRYPT);
            } else {
                $password = $old_password;
            }

            $user_data = [
                "name" => $name,
                "username" => $username,
                "password" => $password,
                "image" => $image,
                "updated_at" => $current_datetime,
            ];

            $db->update("users", $user_data, "id", $account_id);

            $teacher_data = [
                "employee_number" => $employee_number,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "mobile_number" => $mobile_number,
                "email" => $email,
                "address" => $address,
                "updated_at" => $current_datetime,
            ];

            $db->update("teachers", $teacher_data, "account_id", $account_id);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A teacher has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A teacher has been updated successfully.");
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_teacher"])) {
        $id = $_POST["id"];

        $db->delete("users", "id", $id);
        $db->delete("teachers", "account_id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A teacher has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A teacher has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["new_student"])) {
        $student_number = $_POST["student_number"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $section = $_POST["section"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $mobile_number = $_POST["mobile_number"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = $_FILES["image_file"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $response = [
            "student_number_ok" => true,
            "username_ok" => true,
        ];

        $is_error = false;

        if ($db->select_one("students", "student_number", $student_number)) {
            $response["student_number_ok"] = false;

            $is_error = true;
        }

        if ($db->select_one("users", "username", $username)) {
            $response["username_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            $image = upload_image("assets/img/uploads/", $image_file);

            $user_data = [
                "uuid" => generate_uuid(),
                "name" => $name,
                "username" => $username,
                "password" => password_hash($password, PASSWORD_BCRYPT),
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
                "student_number" => $student_number,
                "course" => $course,
                "year" => $year,
                "section" => $section,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "mobile_number" => $mobile_number,
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
        $student_number = $_POST["student_number"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $section = $_POST["section"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $birthday = $_POST["birthday"];
        $mobile_number = $_POST["mobile_number"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $image_file = isset($_FILES["image_file"]) ? $_FILES["image_file"] : null;
        $username = $_POST["username"];
        $password = $_POST["password"];

        $account_id = $_POST["account_id"];
        $old_image = $_POST["old_image"];
        $old_password = $_POST["old_password"];
        $old_student_number = $_POST["old_student_number"];
        $old_username = $_POST["old_username"];

        $is_new_image = $_POST["is_new_image"];
        $is_new_password = $_POST["is_new_password"];

        $response = [
            "student_number_ok" => true,
            "username_ok" => true,
        ];

        $is_error = false;

        if (($student_number != $old_student_number) && ($db->select_one("students", "student_number", $student_number))) {
            $response["student_number_ok"] = false;

            $is_error = true;
        }

        if (($username != $old_username) && ($db->select_one("users", "username", $username))) {
            $response["username_ok"] = false;

            $is_error = true;
        }

        if (!$is_error) {
            if (!empty($middle_name)) {
                $middle_initial = strtoupper(substr($middle_name, 0, 1)) . '.';

                $name = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } else {
                $name = $first_name . ' ' . $last_name;
            }

            if ($is_new_image == "true") {
                $image = upload_image("assets/img/uploads/", $image_file);
            } else {
                $image = $old_image;
            }

            if ($is_new_password == "true") {
                $password = password_hash($password, PASSWORD_BCRYPT);
            } else {
                $password = $old_password;
            }

            $user_data = [
                "name" => $name,
                "username" => $username,
                "password" => $password,
                "image" => $image,
                "updated_at" => $current_datetime,
            ];

            $db->update("users", $user_data, "id", $account_id);

            $student_data = [
                "student_number" => $student_number,
                "course" => $course,
                "year" => $year,
                "section" => $section,
                "first_name" => $first_name,
                "middle_name" => $middle_name,
                "last_name" => $last_name,
                "birthday" => $birthday,
                "mobile_number" => $mobile_number,
                "email" => $email,
                "address" => $address,
                "updated_at" => $current_datetime,
            ];

            $db->update("students", $student_data, "account_id", $account_id);

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
        $id = $_POST["id"];

        $db->delete("users", "id", $id);
        $db->delete("students", "account_id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A student has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A student has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["new_grade_component"])) {
        $subject_id = $_POST["subject_id"];
        $teacher_id = $_POST["teacher_id"];
        $component = $_POST["component"];
        $weight = $_POST["weight"];

        $response = [
            "component_ok" => true,
            "weight_ok" => true,
        ];

        $sql = "SELECT SUM(weight) AS current_weight_sum FROM grade_components WHERE subject_id = '" . $subject_id . "' GROUP BY subject_id";
        $current_weight_sum = $db->run_custom_query($sql);

        if ($current_weight_sum && intval($current_weight_sum[0]["current_weight_sum"]) + $weight > 100) {
            $response["weight_ok"] = false;
        } else {
            $sql_2 = "SELECT id FROM grade_components WHERE subject_id='" . $subject_id . "' AND component='" . $component . "'";
            $is_component_available = $db->run_custom_query($sql_2);

            if (!$is_component_available) {
                $data = [
                    "uuid" => generate_uuid(),
                    "teacher_id" => $teacher_id,
                    "subject_id" => $subject_id,
                    "component" => $component,
                    "weight" => $weight,
                    "created_at" => $current_datetime,
                    "updated_at" => $current_datetime,
                ];

                $db->insert("grade_components", $data);

                $_SESSION["notification"] = [
                    "title" => "Success!",
                    "text" => "A grade component has been added successfully.",
                    "icon" => "success",
                ];

                insert_log($_SESSION["user_id"], "A grade component has been added successfully.");
            } else {
                $response["component_ok"] = false;
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["update_grade_component"])) {
        $id = $_POST["id"];
        $subject_id = $_POST["subject_id"];
        $teacher_id = $_POST["teacher_id"];
        $component = $_POST["component"];
        $weight = $_POST["weight"];
        $old_weight = $_POST["old_weight"];

        $response = [
            "component_ok" => true,
            "weight_ok" => true,
        ];

        $sql = "SELECT SUM(weight) AS current_weight_sum FROM grade_components WHERE subject_id = '" . $subject_id . "' GROUP BY subject_id";
        $current_weight_sum = $db->run_custom_query($sql);

        if (intval($current_weight_sum[0]["current_weight_sum"]) + $weight - $old_weight > 100) {
            $response["weight_ok"] = false;
        } else {
            $sql_2 = "SELECT id FROM grade_components WHERE subject_id='" . $subject_id . "' AND component='" . $component . "' AND id != '" . $id . "'";
            $is_component_available = $db->run_custom_query($sql_2);

            if (!$is_component_available) {
                $data = [
                    "teacher_id" => $teacher_id,
                    "subject_id" => $subject_id,
                    "component" => $component,
                    "weight" => $weight,
                    "updated_at" => $current_datetime,
                ];

                $db->update("grade_components", $data, "id", $id);

                $_SESSION["notification"] = [
                    "title" => "Success!",
                    "text" => "A grade component has been updated successfully.",
                    "icon" => "success",
                ];

                insert_log($_SESSION["user_id"], "A grade component has been updated successfully.");
            } else {
                $response["component_ok"] = false;
            }
        }

        echo json_encode($response);
    }

    if (isset($_POST["delete_grade_component"])) {
        $id = $_POST["id"];

        $db->delete("grade_components", "id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A grade component has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A grade component has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["check_grade_component_weight"])) {
        $teacher_id = $_POST["teacher_id"];

        $response = !$db->check_subject_weight($teacher_id);

        echo json_encode($response);
    }

    if (isset($_POST["new_student_grade"])) {
        $teacher_id = $_POST["teacher_id"];
        $student_id = $_POST["student_id"];
        $subject_id = $_POST["subject_id"];
        $grade_component_id = $_POST["grade_component_id"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $semester = $_POST["semester"];
        $grade = $_POST["grade"];

        $sql = "SELECT id FROM student_grades WHERE student_id='" . $student_id . "' AND course='" . $course . "' AND year='" . $year . "' AND semester='" . $semester . "' AND subject_id='" . $subject_id . "' AND grade_component_id='" . $grade_component_id . "'";

        if ($db->select_many(null, null, null, null, null, $sql)) {
            $_SESSION["notification"] = [
                "title" => "Oops..",
                "text" => "This specific grade is already in the system for another record.",
                "icon" => "error",
            ];
        } else {
            $data = [
                "uuid" => generate_uuid(),
                "teacher_id" => $teacher_id,
                "student_id" => $student_id,
                "subject_id" => $subject_id,
                "grade_component_id" => $grade_component_id,
                "course" => $course,
                "year" => $year,
                "semester" => $semester,
                "grade" => $grade,
                "created_at" => $current_datetime,
                "updated_at" => $current_datetime,
            ];

            $db->insert("student_grades", $data);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "A grade has been added successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "A grade has been added successfully.");
        }

        echo json_encode(true);
    }

    if (isset($_POST["update_student_grade"])) {
        $id = $_POST["id"];
        $teacher_id = $_POST["teacher_id"];
        $student_id = $_POST["student_id"];
        $subject_id = $_POST["subject_id"];
        $grade_component_id = $_POST["grade_component_id"];
        $course = $_POST["course"];
        $year = $_POST["year"];
        $semester = $_POST["semester"];
        $grade = $_POST["grade"];

        $sql = "SELECT id FROM student_grades WHERE student_id='" . $student_id . "' AND course='" . $course . "' AND year='" . $year . "' AND semester='" . $semester . "' AND subject_id='" . $subject_id . "' AND grade_component_id='" . $grade_component_id . "' AND id != '" . $id . "'";

        if ($db->select_many(null, null, null, null, null, $sql)) {
            $_SESSION["notification"] = [
                "title" => "Oops..",
                "text" => "This specific grade is already in the system for another record.",
                "icon" => "error",
            ];
        } else {
            $data = [
                "teacher_id" => $teacher_id,
                "student_id" => $student_id,
                "subject_id" => $subject_id,
                "grade_component_id" => $grade_component_id,
                "course" => $course,
                "year" => $year,
                "semester" => $semester,
                "grade" => $grade,
                "updated_at" => $current_datetime,
            ];

            $db->update("student_grades", $data, "id", $id);

            $_SESSION["notification"] = [
                "title" => "Success!",
                "text" => "The grade has been updated successfully.",
                "icon" => "success",
            ];

            insert_log($_SESSION["user_id"], "The grade has been updated successfully.");
        }

        echo json_encode(true);
    }

    if (isset($_POST["delete_student_grade"])) {
        $id = $_POST["id"];

        $db->delete("student_grades", "id", $id);

        $_SESSION["notification"] = [
            "title" => "Success!",
            "text" => "A student grade has been deleted successfully.",
            "icon" => "success",
        ];

        insert_log($_SESSION["user_id"], "A student grade has been deleted successfully.");

        echo json_encode(true);
    }

    if (isset($_POST["get_grade_data"])) {
        $teacher_id = $_POST["teacher_id"];
        $student_id = $_POST["student_id"];
        $subject_id = $_POST["subject_id"];

        $grade_components = $db->select_many("grade_components", "teacher_id", $teacher_id);

        $components = array();
        $grades = array();

        foreach ($grade_components as $grade_component) {
            $component_id = $grade_component['id'];

            $sql = "SELECT grade FROM student_grades WHERE student_id=$student_id AND teacher_id=$teacher_id AND grade_component_id=$component_id AND subject_id=$subject_id";
            $grade = $db->run_custom_query($sql);

            if ($grade) {
                array_push($components, $grade_component["component"]);
                array_push($grades, $grade[0]["grade"]);
            }
        }

        $response = [
            "components" => $components,
            "grades" => $grades,
        ];

        echo json_encode($response);
    }

    if (isset($_POST["backup_database"])) {
        $backup = $db->backup("backup");

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
        $backup_dir = 'backup/';
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
    http_response_code(500);

    echo "Direct access is not allowed!";
}
