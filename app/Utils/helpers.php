<?php

if (!function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear()
    {
        $currentYear = now()->year;
        return now()->month >= 9 ? $currentYear . '/' . ($currentYear + 1) : ($currentYear - 1) . '/' . $currentYear;
    }
}

