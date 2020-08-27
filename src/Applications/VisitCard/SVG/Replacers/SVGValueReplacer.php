<?php


namespace App\Applications\VisitCard\SVG\Replacers;


use App\Applications\VisitCard\Element;
use App\Applications\VisitCard\Replacer;
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