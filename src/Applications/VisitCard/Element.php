<?php
namespace App\Applications\VisitCard;
interface Element
{
    public function getValue();

    public function setValue($value);

    public function getParent();

    public function replaceBy($element, string $type): bool;
}