<?php
/**
 * Application Helpers & Theme Resolution
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

/**
 * Determine the active theme: 'theme-day' or 'theme-night'
 * Returns an array: ['class' => 'theme-day'|'theme-night', 'mode' => 'day'|'night', 'preference' => 'auto'|'day'|'night']
 */
function resolveCurrentTheme($settings = []) {
    // Check if user has explicit cookie
    $userPreference = isset($_COOKIE['ds_theme_pref']) ? $_COOKIE['ds_theme_pref'] : null;

    if (!$userPreference) {
        $userPreference = $settings['default_theme_mode'] ?? 'auto';
    }

    if ($userPreference === 'day') {
        return [
            'class' => 'theme-day',
            'mode' => 'day',
            'preference' => 'day'
        ];
    } elseif ($userPreference === 'night') {
        return [
            'class' => 'theme-night',
            'mode' => 'night',
            'preference' => 'night'
        ];
    }

    // Auto mode: calculate by current solar time
    // Day between 06:00 (6 AM) and 18:30 (6:30 PM)
    $currentHour = (int)date('G');
    $currentMinute = (int)date('i');
    $timeInMinutes = ($currentHour * 60) + $currentMinute;

    $sunrise = 6 * 60;        // 06:00
    $sunset = 18 * 60 + 30;   // 18:30

    $isDayTime = ($timeInMinutes >= $sunrise && $timeInMinutes < $sunset);
    $activeMode = $isDayTime ? 'day' : 'night';

    return [
        'class' => $isDayTime ? 'theme-day' : 'theme-night',
        'mode' => $activeMode,
        'preference' => 'auto'
    ];
}

/**
 * Handle image upload safely
 */
function handleImageUpload($fileInputName, $targetSubdir = 'uploads') {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$fileInputName];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    $fileInfo = pathinfo($file['name']);
    $extension = strtolower($fileInfo['extension'] ?? '');

    if (!in_array($extension, $allowedExtensions)) {
        return null;
    }

    // Validate mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
    if (!in_array($mime, $allowedMimes)) {
        return null;
    }

    $uploadDir = __DIR__ . '/../assets/images/' . trim($targetSubdir, '/');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newFileName = uniqid('img_', true) . '.' . $extension;
    $destination = $uploadDir . '/' . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return 'assets/images/' . trim($targetSubdir, '/') . '/' . $newFileName;
    }

    return null;
}
