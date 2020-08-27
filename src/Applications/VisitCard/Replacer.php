<?php
namespace App\Applications\VisitCard;
interface Replacer {
    public function replace(Element $placeholder, $input);
}