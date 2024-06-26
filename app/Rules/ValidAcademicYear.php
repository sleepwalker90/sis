<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAcademicYear implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the format matches YYYY/YYYY
        if (!preg_match('/^\d{4}\/\d{4}$/', $value)) {
            $fail('The :attribute must be in the format YYYY/YYYY.');
            return;
        }

        // Split the value into two parts
        [$startYear, $endYear] = explode('/', $value);

        // Check if the end year is the start year plus one
        if ((int)$endYear !== (int)$startYear + 1) {
            $fail('The :attribute must be in the format YYYY/YYYY and the second year must be the first year plus one.');
        }
    }
}
