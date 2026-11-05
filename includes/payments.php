<?php

function payment_methods()
{
    return ['cod' => 'Thanh toán khi nhận hàng (COD)', 'bank_transfer' => 'Chuyển khoản ngân hàng (QR)'];
}

function payment_status_label($status)
{
    return [
        'unpaid' => 'Chưa thanh toán',
        'reported' => 'Chờ đối soát chuyển khoản',
        'paid' => 'Đã thanh toán',
        'refund_pending' => 'Chờ shop hoàn tiền',
        'refunded' => 'Shop đã xác nhận hoàn tiền',
    ][$status] ?? $status;
}

function payment_receiver($order = [])
{
    return [
        'bank_bin' => $order['payment_bank_bin'] ?? PAYMENT_BANK_BIN,
        'bank_name' => $order['payment_bank_name'] ?? PAYMENT_BANK_NAME,
        'account_number' => $order['payment_account_number'] ?? PAYMENT_ACCOUNT_NUMBER,
        'account_name' => $order['payment_account_name'] ?? PAYMENT_ACCOUNT_NAME,
    ];
}

// EMV/VietQR length-value fields, in bytes. The payload contains no URLs or scripts.
function payment_tlv($id, $value)
{
    if (strlen($value) > 99) throw new RuntimeException('Dữ liệu QR vượt quá giới hạn.');
    return $id . str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT) . $value;
}

function payment_crc($payload)
{
    $crc = 0xffff;
    for ($index = 0; $index < strlen($payload); $index++) {
        $crc ^= ord($payload[$index]) << 8;
        for ($bit = 0; $bit < 8; $bit++) {
            $crc = (($crc & 0x8000) ? ($crc << 1) ^ 0x1021 : $crc << 1) & 0xffff;
        }
    }
    return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
}

function payment_qr_payload($order)
{
    $receiver = payment_receiver($order);
    $reference = $order['payment_reference'] ?? '';
    $amount = (int) $order['total'];
    if (!preg_match('/^\d{6}$/', $receiver['bank_bin']) ||
        !preg_match('/^\d{6,34}$/', $receiver['account_number']) ||
        !preg_match('/^TN[0-9]{6,20}$/', $reference) || $amount < 1) {
        throw new RuntimeException('Thông tin thanh toán không hợp lệ.');
    }
    $beneficiary = payment_tlv('00', $receiver['bank_bin']) . payment_tlv('01', $receiver['account_number']);
    $merchant = payment_tlv('00', 'A000000727') . payment_tlv('01', $beneficiary) . payment_tlv('02', 'QRIBFTTA');
    $payload = payment_tlv('00', '01') . payment_tlv('01', '12') . payment_tlv('38', $merchant)
        . payment_tlv('53', '704') . payment_tlv('54', (string) $amount) . payment_tlv('58', 'VN')
        . payment_tlv('62', payment_tlv('08', $reference)) . '6304';
    return $payload . payment_crc($payload);
}

function payment_qr_matrix($order)
{
    require_once __DIR__ . '/vendor/qrcode.php';
    $qr = new QRCode();
    $qr->setTypeNumber(9);
    $qr->setErrorCorrectLevel(QR_ERROR_CORRECT_LEVEL_M);
    $qr->addData(payment_qr_payload($order), QR_MODE_8BIT_BYTE);
    $qr->make();
    return $qr;
}

function payment_qr_svg($order)
{
    $qr = payment_qr_matrix($order);
    $size = $qr->getModuleCount();
    $path = '';
    for ($row = 0; $row < $size; $row++) {
        for ($col = 0; $col < $size; $col++) {
            if ($qr->isDark($row, $col)) $path .= 'M' . ($col + 4) . ' ' . ($row + 4) . 'h1v1h-1z';
        }
    }
    return '<svg class="payment-qr" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . ($size + 8) . ' ' . ($size + 8)
        . '" role="img" aria-label="Mã QR chuyển khoản ngân hàng cho đơn hàng" shape-rendering="crispEdges"><rect width="100%" height="100%" fill="white"/><path d="'
        . $path . '" fill="black"/></svg>';
}

// Grayscale PNG with a four-module quiet zone; works without the GD extension.
function payment_qr_png($order)
{
    $qr = payment_qr_matrix($order);
    $size = $qr->getModuleCount();
    $scale = 8;
    $width = ($size + 8) * $scale;
    $raw = '';
    for ($row = -4; $row < $size + 4; $row++) {
        $line = '';
        for ($col = -4; $col < $size + 4; $col++) {
            $dark = $row >= 0 && $row < $size && $col >= 0 && $col < $size && $qr->isDark($row, $col);
            $line .= str_repeat($dark ? "\x00" : "\xff", $scale);
        }
        $raw .= str_repeat("\x00" . $line, $scale);
    }
    $chunk = static function ($type, $data) {
        return pack('N', strlen($data)) . $type . $data . pack('N', crc32($type . $data));
    };
    return "\x89PNG\r\n\x1a\n" . $chunk('IHDR', pack('NNCCCCC', $width, $width, 8, 0, 0, 0, 0))
        . $chunk('IDAT', gzcompress($raw, 9)) . $chunk('IEND', '');
}

// Call only while holding the order row lock. Cancellation never sends money.
function payment_status_after_cancel($status)
{
    return $status === 'paid' ? 'refund_pending' : $status;
}
