<?php
declare(strict_types=1);

namespace Common\Serialization;

function json_encode($value) {
    $json = \json_encode($value, JSON_PRETTY_PRINT, 512);
    if (JSON_ERROR_NONE !== json_last_error()) {
        throw new \InvalidArgumentException(
            'json_encode error: ' . json_last_error_msg());
    }

    return $json;
}
