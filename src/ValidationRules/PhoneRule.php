<?php

namespace Salah\LaravelCustomFields\ValidationRules;

class PhoneRule extends ValidationRule
{
    public function name(): string
    {
        return 'phone';
    }

    public function label(): string
    {
        return 'Phone Format (e.g., US,EG,mobile)';
    }

    public function baseRule(): array
    {
        return ['string'];
    }

    public function htmlTag(): string
    {
        return 'input';
    }

    public function placeholder(): string
    {
        return 'e.g., US,EG,mobile';
    }

    public function description(): string
    {
        return 'Validates the phone number format. Leave empty for automatic detection.';
    }

    public function defaultConfigValue(): mixed
    {
        return '';
    }

    public function apply($value): string
    {
        if (empty($value)) {
            return 'phone:AUTO';
        }

        return "phone:{$value}";
    }
}
