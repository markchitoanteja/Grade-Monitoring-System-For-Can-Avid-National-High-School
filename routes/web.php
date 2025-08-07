<?php
$routes = [
    // Authentication
    ''                      => 'views/auth/login.php',
    'login'                 => 'views/auth/login.php',

    // Main Pages
    'main'                  => 'views/pages/main.php',
    'dashboard'             => 'views/pages/dashboard.php',
    'strands'               => 'views/pages/strands.php',
    'students'              => 'views/pages/students.php',
    'subjects'              => 'views/pages/subjects.php',
    'grades'                => 'views/pages/grades.php',
    'backup_and_restore'    => 'views/pages/backup_and_restore.php',
    
    // API Endpoints
    'server'                => 'api/server.php',

    // Error Pages
    '403'                   => 'views/errors/403.php',
    '404'                   => 'views/errors/404.php',
    '500'                   => 'views/errors/500.php',
    'no_function_yet'       => 'views/errors/no_function_yet.php',
    'trial_ended'           => 'views/errors/trial_ended.php',
];
