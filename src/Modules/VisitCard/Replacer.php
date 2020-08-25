<?php
namespace App\Modules\VisitCard;
interface Replacer {
    public function replace(Element $placeholder, $input);
}