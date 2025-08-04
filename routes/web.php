<?php
$routes = [
    // Authentication
    ''                      => 'views/auth/login.php',
    'login'                 => 'views/auth/login.php',

    // Main Pages
    'main'                  => 'views/pages/main.php',
    'dashboard'             => 'views/pages/dashboard.php',
    'courses'               => 'views/pages/courses.php',
    'subjects'              => 'views/pages/subjects.php',
    'teachers'              => 'views/pages/teachers.php',
    'students'              => 'views/pages/students.php',
    'backup_and_restore'    => 'views/pages/backup_and_restore.php',
    'grade_components'      => 'views/pages/grade_components.php',
    'grade_entries'         => 'views/pages/grade_entries.php',
    'student_grades'        => 'views/pages/student_grades.php',
    'my_grades'             => 'views/pages/my_grades.php',

    // API Endpoints
    'server'                => 'api/server.php',

    // Error Pages
    '403'                   => 'views/errors/403.php',
    '404'                   => 'views/errors/404.php',
    '500'                   => 'views/errors/500.php',
    'no_function_yet'       => 'views/errors/no_function_yet.php',
    'trial_ended'           => 'views/errors/trial_ended.php',
];
