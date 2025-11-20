<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTimeZone;

define('SHOW_TIME_FOR_SAME_DAY', 0);
define('NEVER_SHOW_TIME', 1);
define('ALWAYS_SHOW_TIME', 2);
define('SHOW_TIME_FOR_SAME_DAY_WITH_SECONDS', 3);
define('ALWAYS_SHOW_TIME_WITH_SECONDS', 4);

class DateX
{
    /**
     * Format the $input to the given $format.
     */
    public static function format(string $format, null|string|Carbon $input = null, null|int|string|DateTimeZone $tz = null, ?string $default = '-', bool $translated = true): ?string
    {
        if ($input === null) {
            return $default;
        }

        $input = static::parseInput($input, $tz);

        return $translated ? $input->translatedFormat($format) : $input->format($format);
    }

    /**
     * Format the $input to a time string.
     */
    public static function formatTime(null|string|Carbon $input = null, null|int|string|DateTimeZone $tz = null, bool $withSeconds = false, string $default = '-'): string
    {
        if ($input === null) {
            return $default;
        }

        return static::parseInput($input, $tz)->translatedFormat($withSeconds ? 'H:i:s' : 'H:i');
    }

    /**
     * Format the $input to a date string.
     */
    public static function formatDate(null|string|Carbon $input = null, null|int|string|DateTimeZone $tz = null, string $default = '-'): string
    {
        if ($input === null) {
            return $default;
        }

        return static::parseInput($input, $tz)->translatedFormat('D d.m.Y');
    }

    /**
     * Format the $input to a datetime string.
     */
    public static function formatDatetime(null|string|Carbon $input = null, null|int|string|DateTimeZone $tz = null, bool $withSeconds = false, string $default = '-'): string
    {
        if ($input === null) {
            return $default;
        }

        return static::parseInput($input, $tz)->translatedFormat($withSeconds ? 'D d.m.Y H:i:s' : 'D d.m.Y H:i');
    }

    /**
     * Format the range $from - $until in the given $mode.
     */
    public static function formatRange(null|string|Carbon $from = null, null|string|Carbon $until = null, null|int|string|DateTimeZone $tz = null, int $mode = SHOW_TIME_FOR_SAME_DAY, string $default = '-'): string
    {
        // Both inputs are null
        if ($from === null && $until === null) {
            return $default;
        } // One of the inputs is null
        elseif (($from === null && $until !== null) || ($from !== null && $until === null)) {
            return match ($mode) {
                SHOW_TIME_FOR_SAME_DAY => static::formatDatetime($from ?? $until, $tz),
                NEVER_SHOW_TIME => static::formatDate($from ?? $until, $tz),
                ALWAYS_SHOW_TIME => static::formatDatetime($from ?? $until, $tz),
                SHOW_TIME_FOR_SAME_DAY_WITH_SECONDS => static::formatDatetime($from ?? $until, $tz, withSeconds: true),
                ALWAYS_SHOW_TIME_WITH_SECONDS => static::formatDatetime($from ?? $until, $tz, withSeconds: true),
            };
        }

        // Parse values to Carbon instances
        $from = static::parseInput($from, $tz);
        $until = static::parseInput($until, $tz);

        // If from and until are in the wrong order, swap them
        if ($from->isAfter($until)) {
            [$until, $from] = [$from, $until];
        }

        // Handle format for the same day
        if ($from->isSameDay($until)) {
            return match ($mode) {
                SHOW_TIME_FOR_SAME_DAY => static::formatDatetime($from, $tz) . ' - ' . static::formatTime($until, $tz),
                NEVER_SHOW_TIME => static::formatDate($from, $tz),
                ALWAYS_SHOW_TIME => static::formatDatetime($from, $tz) . ' - ' . static::formatTime($until, $tz),
                SHOW_TIME_FOR_SAME_DAY_WITH_SECONDS => static::formatDatetime($from, $tz, withSeconds: true) . ' - ' . static::formatTime($until, $tz, withSeconds: true),
                ALWAYS_SHOW_TIME_WITH_SECONDS => static::formatDatetime($from, $tz, withSeconds: true) . ' - ' . static::formatTime($until, $tz, withSeconds: true),
                default => static::formatDatetime($from, $tz) . ' - ' . static::formatTime($until, $tz),
            };
        }

        // Handle format for different days
        return match ($mode) {
            SHOW_TIME_FOR_SAME_DAY => static::formatDate($from, $tz) . ' - ' . static::formatDate($until, $tz),
            NEVER_SHOW_TIME => static::formatDate($from, $tz) . ' - ' . static::formatDate($until, $tz),
            ALWAYS_SHOW_TIME => static::formatDatetime($from, $tz) . ' - ' . static::formatDatetime($until, $tz),
            SHOW_TIME_FOR_SAME_DAY_WITH_SECONDS => static::formatDate($from, $tz) . ' - ' . static::formatDate($until, $tz),
            ALWAYS_SHOW_TIME_WITH_SECONDS => static::formatDatetime($from, $tz, withSeconds: true) . ' - ' . static::formatDatetime($until, $tz, withSeconds: true),
            default => static::formatDate($from, $tz) . ' - ' . static::formatDate($until, $tz),
        };
    }

    #region Helpers

    private static function parseInput(null|string|Carbon $input = null, null|int|string|DateTimeZone $tz = null): Carbon
    {
        $input = $input instanceof Carbon ? $input->copy() : Carbon::parse($input);
        $input = $input->setTimezone($tz ?? 'Europe/Vienna');

        return $input;
    }

    #endregion Helpers
}
