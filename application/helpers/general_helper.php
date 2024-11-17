<?php

if (!function_exists("avatar")) {
    /**
     * falls back to default avatar if user has no avatar
     * @param string|null $avatar
     * @return string
     */
    function avatar(string|null $avatar = ""): string
    {
        return $avatar ? base_url("uploads/avatars/" . $avatar) : base_url("assets/images/default-avatar.png");
    }
}


if (!function_exists("selected")) {
    function selected(bool $isSelected): string
    {
        return $isSelected ? "selected" : "";
    }
}

if (!function_exists("active")) {
    function active(bool $isActive): string
    {
        return $isActive ? "active" : "";
    }
}

if (!function_exists("months_names")) {
    function months_names(string $language): array
    {
        $months = [
            "EN" => ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            "AR" => ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]
        ];

        return $months[$language];
    }
}

if (!function_exists("months_three_letters_names")) {
    function months_three_letters_names(string $language): array
    {
        $months = [
            "EN" => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            "AR" => months_names('AR')
        ];

        return $months[$language];
    }
}

if (!function_exists("throw_if")) {
    /**
     * @throws Exception
     */
    function throw_if(bool $condition, Exception|string $exception): void
    {
        if (!$condition) return;
        if (is_string($exception)) {
            $exception = new Exception($exception);
        }

        throw $exception;
    }
}

if (!function_exists("get_full_language_name")) {
    function get_full_language_name(string $language): string
    {
        return strtolower($language) === 'en' ? "english" : "arabic";
    }
}

if (!function_exists("array_wrap")) {
    function array_wrap(mixed $value): array
    {
        return is_array($value) ? $value : [$value];
    }
}

if (!function_exists("blank")) {
    function blank(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}
