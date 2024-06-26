<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($value, 'BG');
            if (!$phoneUtil->isValidNumber($numberProto)) {
                $fail('The :attribute is not a valid phone number.');
            }
        } catch (\libphonenumber\NumberParseException $e) {
            $fail('The :attribute is not a valid phone number.');
        }
    }

}
