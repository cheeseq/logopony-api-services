<?php


namespace App\ValidationRules;


use Rakit\Validation\Rule;

class IsDirectoryRule extends Rule
{
    protected $message = "The :attribute is not a directory";

    public function check($value): bool
    {
        return is_dir($value);
    }
}