<?php
function env_value(string $name, string $fallback = ''): string
{
    $value = getenv($name);
    return $value === false ? $fallback : $value;
}

$host = env_value('DB_HOST', env_value('MYSQLHOST', 'localhost'));
$user = env_value('DB_USER', env_value('MYSQLUSER', 'root'));
$password = env_value('DB_PASSWORD', env_value('MYSQLPASSWORD', ''));
$database = env_value('DB_NAME', env_value('MYSQLDATABASE', 'staff_db'));
$port = (int) env_value('DB_PORT', env_value('MYSQLPORT', '3306'));

$frontendUrl = trim(env_value('FRONTEND_URL'));
if ($frontendUrl !== '') {
    header('Access-Control-Allow-Origin: ' . $frontendUrl);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    die('Database connection unavailable.');
}

$conn->set_charset('utf8mb4');
?>