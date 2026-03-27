<?php

function cleanString($string) {
    $str = trim($string);
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}

/**
 * Escape output for XSS protection
 * @param string $string The string to escape
 * @return string Escaped string safe for HTML output
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Secure file upload with validation
 * @param array $file $_FILES array element
 * @param string $uploadPath Destination path
 * @param array $allowedTypes Allowed MIME types
 * @param array $allowedExtensions Allowed file extensions
 * @param int $maxSize Maximum file size in bytes (default 5MB)
 * @return array ['success' => bool, 'filename' => string, 'error' => string]
 */
function secureFileUpload($file, $uploadPath, $allowedTypes = null, $allowedExtensions = null, $maxSize = 5242880) {
    $result = ['success' => false, 'filename' => '', 'error' => ''];

    // Default allowed types for images
    if ($allowedTypes === null) {
        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];
    }

    // Default allowed extensions
    if ($allowedExtensions === null) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    }

    // Check if file was uploaded
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        $result['error'] = 'No file uploaded';
        return $result;
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'Upload error: ' . $file['error'];
        return $result;
    }

    // Check file size
    if ($file['size'] > $maxSize) {
        $result['error'] = 'File too large. Maximum size: ' . ($maxSize / 1048576) . 'MB';
        return $result;
    }

    // Get file extension
    $originalName = basename($file['name']);
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $result['error'] = 'Invalid file extension. Allowed: ' . implode(', ', $allowedExtensions);
        return $result;
    }

    // Validate MIME type using finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedTypes)) {
        $result['error'] = 'Invalid file type. Detected: ' . $mimeType;
        return $result;
    }

    // For images, verify it's actually an image
    if (strpos($mimeType, 'image/') === 0) {
        $imageInfo = @getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            $result['error'] = 'File is not a valid image';
            return $result;
        }
    }

    // Generate secure random filename
    $newFilename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $extension;

    // Ensure upload directory exists
    if (!is_dir($uploadPath)) {
        if (!@mkdir($uploadPath, 0755, true)) {
            $result['error'] = 'Upload directory could not be created. Please create it manually and set permissions to 0755.';
            return $result;
        }
    }

    // Check directory is writable
    if (!is_writable($uploadPath)) {
        $result['error'] = 'Upload directory is not writable. Please set permissions to 0755 on: ' . basename($uploadPath);
        return $result;
    }

    // Move uploaded file
    $destination = rtrim($uploadPath, '/') . '/' . $newFilename;
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $result['success'] = true;
        $result['filename'] = $newFilename;
        $result['path'] = $destination;
    } else {
        $result['error'] = 'Failed to move uploaded file. Check directory permissions (need 0755).';
    }

    return $result;
}

/**
 * Secure multiple file upload
 * @param array $files $_FILES array with multiple files
 * @param string $uploadPath Destination path
 * @return array Array of upload results
 */
function secureMultipleFileUpload($files, $uploadPath) {
    $results = [];

    if (!isset($files['tmp_name']) || !is_array($files['tmp_name'])) {
        return $results;
    }

    $fileCount = count($files['tmp_name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $file = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i]
        ];

        if (!empty($file['tmp_name'])) {
            $results[] = secureFileUpload($file, $uploadPath);
        }
    }

    return $results;
}

/**
 * Hash password using modern algorithm (Argon2 with fallback to bcrypt)
 * @param string $password Plain text password
 * @return string Hashed password
 */
function securePasswordHash($password) {
    // Use Argon2ID if available (PHP 7.3+), otherwise bcrypt
    if (defined('PASSWORD_ARGON2ID')) {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3
        ]);
    }
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password with backward compatibility for MD5
 * Handles migration from MD5 to modern hashing
 * @param string $password Plain text password
 * @param string $hash Stored hash (MD5 or modern)
 * @param callable|null $updateCallback Optional callback to update hash in database
 * @return bool True if password matches
 */
function verifyPassword($password, $hash, $updateCallback = null) {
    // Check if it's a modern hash (starts with $ for bcrypt/argon2)
    if (strpos($hash, '$') === 0) {
        $valid = password_verify($password, $hash);

        // Check if rehash is needed (algorithm upgrade)
        if ($valid && password_needs_rehash($hash, PASSWORD_ARGON2ID ?? PASSWORD_BCRYPT)) {
            if (is_callable($updateCallback)) {
                $newHash = securePasswordHash($password);
                $updateCallback($newHash);
            }
        }

        return $valid;
    }

    // Legacy MD5 hash check (32 character hex string)
    if (strlen($hash) === 32 && ctype_xdigit($hash)) {
        $valid = (md5($password) === $hash);

        // If valid, migrate to modern hash
        if ($valid && is_callable($updateCallback)) {
            $newHash = securePasswordHash($password);
            $updateCallback($newHash);
        }

        return $valid;
    }

    return false;
}

/**
 * Check if password hash needs migration from MD5
 * @param string $hash The stored password hash
 * @return bool True if hash is legacy MD5
 */
function isLegacyHash($hash) {
    // MD5 hashes are 32 character hex strings
    return strlen($hash) === 32 && ctype_xdigit($hash);
}

function isGET($get) {
    if (isset($_GET[$get])) {
        return true;
    } else {
        return false;
    }
}

function GET($get, $HTML = true) {
    $get = $_GET[$get];
    if ($HTML) {
        $get = strip_tags($get);
        $get = htmlentities($get);
    }
    $get = htmlentities($get, ENT_QUOTES);
    $get = stripslashes($get);
    $get = str_replace("'", "&apos;", $get);
    $get = db_real_escape_string($get);
    $get = trim($get);
    return $get;
}

function msgBox($messageType, $messgageText) {
    $messageType = strtolower($messageType);
    $msgType = "danger";
    $msgTitle = "Error!";
    switch ($messageType) {
        case 'ok':
        case 'OK';
            $msgType = "success";
            $msgTitle = "OK!";
            break;
        case 'info':
        case 'tip':
            $msgTitle = "Info!";
            $msgType = "info";
            break;
        case 'warning':
        case 'alert':
            $msgTitle = "Warning!";
            $msgType = "warning";
            break;
        case 'welcome';
            $msgType = "success";
            $msgTitle = "Welcome!";
            break;
        case 'welldone';
            $msgType = "success";
            $msgTitle = "Welldone!";
            break;
        case 'oh';
            $msgType = "danger";
            $msgTitle = "Oh!";
            break;
         default:
            break;
    }
    ?>
    <div class="alert alert-<?php echo $msgType ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?php echo $msgTitle ?></strong> <?php echo $messgageText ?>
    </div>
    <?php
}

function get_time_difference_php($created_time)
 {
        date_default_timezone_set('Asia/Karachi'); //Change as per your default time
        $str = strtotime($created_time);
        $today = strtotime(date('F j, Y, g:i a'));

        // It returns the time difference in Seconds...
        $time_differnce = $today-$str;

        // To Calculate the time difference in Years...
        $years = 60*60*24*365;

        // To Calculate the time difference in Months...
        $months = 60*60*24*30;

        // To Calculate the time difference in Days...
        $days = 60*60*24;

        // To Calculate the time difference in Hours...
        $hours = 60*60;

        // To Calculate the time difference in Minutes...
        $minutes = 60;

        if(intval($time_differnce/$years) > 1)
        {
            return intval($time_differnce/$years)." years ago";
        }else if(intval($time_differnce/$years) > 0)
        {
            return intval($time_differnce/$years)." year ago";
        }else if(intval($time_differnce/$months) > 1)
        {
            return intval($time_differnce/$months)." months ago";
        }else if(intval(($time_differnce/$months)) > 0)
        {
            return intval(($time_differnce/$months))." month ago";
        }else if(intval(($time_differnce/$days)) > 1)
        {
            return intval(($time_differnce/$days))." days ago";
        }else if (intval(($time_differnce/$days)) > 0) 
        {
            return intval(($time_differnce/$days))." day ago";
        }else if (intval(($time_differnce/$hours)) > 1) 
        {
            return intval(($time_differnce/$hours))." hours ago";
        }else if (intval(($time_differnce/$hours)) > 0) 
        {
            return intval(($time_differnce/$hours))." hour ago";
        }else if (intval(($time_differnce/$minutes)) > 1) 
        {
            return intval(($time_differnce/$minutes))." minutes ago";
        }else if (intval(($time_differnce/$minutes)) > 0) 
        {
            return intval(($time_differnce/$minutes))." minute ago";
        }else if (intval(($time_differnce)) > 1) 
        {
            return intval(($time_differnce))." seconds ago";
        }else
        {
            return "few seconds ago";
        }
  }