<?php
$users = [
    [
        'usuario' => 'profesor',
        'contrasena' => password_hash('prof123', PASSWORD_DEFAULT),
        'role' => 'profesor'
    ],
    
    [
        'usuario' => 'juan',
        'contrasena' => password_hash('stud123', PASSWORD_DEFAULT),
        'role' => 'estudiante',
        'nota' => 88
    ],
    [
        'usuario' => 'maria',
        'contrasena' => password_hash('stud234', PASSWORD_DEFAULT),
        'role' => 'estudiante',
        'nota' => 75
    ],
    'usuario' => [
        'usuario' => 'carlos',
        'contrasena' => password_hash('stud345', PASSWORD_DEFAULT),
        'role' => 'estudiante',
        'nota' => 100
    ]
];