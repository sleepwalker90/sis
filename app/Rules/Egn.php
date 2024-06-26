<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Egn implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[0-9]{10}$/', $value)) {
            $fail('The :attribute must be exactly 10 digits.');
            return;
        }

        $year = substr($value, 0, 2);
        $month = substr($value, 2, 2);
        $day = substr($value, 4, 2);

        if ($month > 40) {
            $year = 2000 + $year;
            $month = $month - 40;
        } elseif ($month > 20) {
            $year = 1800 + $year;
            $month = $month - 20;
        } else {
            $year = 1900 + $year;
        }

        if (!checkdate($month, $day, $year)) {
            $fail('The :attribute contains an invalid date.');
            return;
        }

        $checksum = 0;
        $weights = [2, 4, 8, 5, 10, 9, 7, 3, 6];

        for ($i = 0; $i < 9; $i++) {
            $checksum += intval($value[$i]) * $weights[$i];
        }

        $checksum = $checksum % 11;
        $checksum = $checksum == 10 ? 0 : $checksum;

        if ($checksum != intval($value[9])) {
            $fail('The :attribute is not a valid EGN.');
        }
    }
}
