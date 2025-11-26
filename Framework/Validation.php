<?php

namespace Framework;

class Validation {
    /**
     * Validate a string
     * 
     * @param string $value
     * @param int $min
     * @param int $max
     * @return bool
     */

    public static function string($value, $min = 1, $max = INF ): bool {
        if(is_string(value: $value)) {
            $value = trim(string: $value);
            $length = strlen(string: $value);
            return $length >= $min && $length <= $max;
        }
        return false;
    }

    /**
     * Validate email address
     * 
     * @param string $value
     * @return mixed
     */

    public static function email($value): mixed {
        $value = trim(string: $value);

        return filter_var(value: $value, filter: FILTER_VALIDATE_EMAIL);
    }

    /**
     * Match a value against another 
     * 
     * @param string $value
     * @return bool
     */
    public static function match($value1, $value2): bool {
        $value1 = trim(string: $value1);
        $value2 = trim(string: $value2);

        return $value1 === $value2;
    }
}