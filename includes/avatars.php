<?php

function user_initials($fullname)
{
    $parts = preg_split('/\s+/u', trim($fullname), -1, PREG_SPLIT_NO_EMPTY);
    if (!$parts) return 'KH';
    $initials = mb_substr($parts[0], 0, 1);
    if (count($parts) > 1) $initials .= mb_substr($parts[count($parts) - 1], 0, 1);
    return mb_strtoupper($initials);
}

// Only generated avatar paths may be displayed or deleted. Never accept a path from POST.
function managed_avatar_path($path)
{
    return is_string($path) && preg_match('~^uploads/avatars/[a-f0-9]{32}\.(jpg|png|webp)$~D', $path);
}

function user_avatar_url($user)
{
    $path = $user['avatar'] ?? null;
    return managed_avatar_path($path) && is_file(__DIR__ . '/../' . $path) ? url($path) : null;
}

function delete_user_avatar($path)
{
    if (managed_avatar_path($path) && is_file(__DIR__ . '/../' . $path)) {
        if (!unlink(__DIR__ . '/../' . $path)) error_log('Could not remove an unused user avatar.');
    }
}

function upload_user_avatar($file)
{
    if (!is_array($file) || ($file['error'] ?? null) !== UPLOAD_ERR_OK) {
        $error = is_array($file) ? ($file['error'] ?? null) : null;
        if (in_array($error, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            throw new RuntimeException('Ảnh đại diện không được lớn hơn 2 MB.');
        }
        throw new RuntimeException('Chưa tải được ảnh đại diện. Vui lòng chọn lại ảnh và thử lại.');
    }
    $temporaryPath = $file['tmp_name'] ?? null;
    if (!is_string($temporaryPath) || !is_uploaded_file($temporaryPath)) {
        throw new RuntimeException('Tệp ảnh đại diện không hợp lệ.');
    }
    $size = filesize($temporaryPath);
    if (!$size || $size > 2 * 1024 * 1024) {
        throw new RuntimeException('Ảnh đại diện phải có dung lượng từ 1 byte đến 2 MB.');
    }
    $info = @getimagesize($temporaryPath);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!$info || !isset($extensions[$mime]) || $info['mime'] !== $mime) {
        throw new RuntimeException('Chỉ chấp nhận ảnh JPG, PNG hoặc WebP hợp lệ.');
    }
    if ($info[0] < 1 || $info[1] < 1 || $info[0] > 4096 || $info[1] > 4096) {
        throw new RuntimeException('Chiều rộng và chiều cao ảnh không được vượt quá 4096 pixel.');
    }
    $directory = __DIR__ . '/../uploads/avatars';
    if (!is_dir($directory) || !is_writable($directory)) {
        throw new RuntimeException('Chưa lưu được ảnh. Vui lòng liên hệ cửa hàng để kiểm tra thư mục ảnh đại diện.');
    }
    $path = 'uploads/avatars/' . bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($temporaryPath, __DIR__ . '/../' . $path)) {
        throw new RuntimeException('Chưa lưu được ảnh đại diện. Vui lòng thử lại.');
    }
    return $path;
}
