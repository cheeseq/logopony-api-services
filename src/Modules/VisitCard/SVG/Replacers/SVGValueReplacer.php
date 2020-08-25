<?php


namespace App\Modules\VisitCard\SVG\Replacers;


use App\Modules\VisitCard\Element;
use App\Modules\VisitCard\Replacer;
use SVG\Nodes\SVGNode;

class SVGValueReplacer implements Replacer
{
    public function replace(Element $placeholder, $input)
    {
        /** @var SVGNode $placeholderDocumentFragment */
        $placeholderDocumentFragment = $placeholder->getValue();
        $placeholderDocumentFragment->setValue($input);
    }
}