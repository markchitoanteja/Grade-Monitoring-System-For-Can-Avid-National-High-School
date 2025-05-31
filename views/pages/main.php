<?php
if ($_SESSION["user_type"] == "admin") {
    header("location: dashboard");
} elseif ($_SESSION["user_type"] == "teacher") {
    header("location: grade_components");
} elseif ($_SESSION["user_type"] == "student") {
    header("location: my_grades");
} else {
    header("location: no_function_yet");
}
