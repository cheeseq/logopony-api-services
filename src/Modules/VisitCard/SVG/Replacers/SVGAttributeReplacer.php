<?php


namespace App\Modules\VisitCard\SVG\Replacers;


use App\Modules\VisitCard\Element;
use App\Modules\VisitCard\Replacer;
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