<?php
// Sanitize input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}

// Check if admin is logged in
function check_login() {
    session_start();
    if(!isset($_SESSION['admin'])) {
        redirect('../login.php');
    }
}

function upload_profile_image(array $file, string $uploadDir): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    if (($file['size'] ?? 0) > 5 * 1024 * 1024 || !is_uploaded_file($file['tmp_name'])) {
        return null;
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($extensions[$mime])) {
        return null;
    }

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return null;
    }

    $fileName = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    return move_uploaded_file($file['tmp_name'], $uploadDir . $fileName) ? $fileName : null;
}
?>