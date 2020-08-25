<?php


namespace App\ValidationRules;


use Rakit\Validation\Rule;

class IsFileOrDirRule extends Rule
{
    protected $message = "The :attribute is not a file";

    public function check($value): bool
    {
        return file_exists($value);
    }
}