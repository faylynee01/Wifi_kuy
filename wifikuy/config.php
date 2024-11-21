<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

// define(
//     'BASE_URL',
//     'http' .
//         ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 's' : '') .
//         '://' . $_SERVER['HTTP_HOST'] .
//         rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . // Remove trailing slash if it’s the root
//         (dirname($_SERVER['SCRIPT_NAME']) == '/' ? '' : '/') // Add slash only if not root
// );

define(
    'BASE_URL',
    'http' .
        ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 's' : '') .
        '://' . $_SERVER['HTTP_HOST'] .
        rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'  // Ensure it ends with a slash
);



define(
    'DOMAIN',
    'http' .
        ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 's' : '') .
        '://' . $_SERVER['HTTP_HOST'] . '/'
);

define('REAL_DOMAIN', $_SERVER['HTTP_HOST']);



const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_DATABASE = "wifikuy";

const TOKEN_LIFETIME = 120;

const SMTP_SERVER = "smtp.gmail.com";
const SMTP_PORT = "465";
const SMTP_USERNAME = "pos.system.automation@gmail.com";
const SMTP_PASSWORD = "jaebkylrzsumwaxd";
const SMTP_SECURE = "ssl";
