<?php


namespace App\Applications\VisitCard\SVG\Replacers;


use App\Applications\VisitCard\Element;
use App\Applications\VisitCard\Replacer;
use SVG\Nodes\SVGNode;

abstract class SVGAttributeReplacer implements Replacer
{
    public function replace(Element $placeholder, $input)
    {
        /** @var SVGNode $placeholderDocumentFragment */
        $placeholderDocumentFragment = $placeholder->getValue();
        $placeholderDocumentFragment->setAttribute($this->getAttributeName(), $input);
    }

    abstract protected function getAttributeName(): string;
}