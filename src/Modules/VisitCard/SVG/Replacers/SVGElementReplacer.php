<?php


namespace App\Modules\VisitCard\SVG\Replacers;


use App\Modules\VisitCard\Element;
use App\Modules\VisitCard\Replacer;
use SVG\Nodes\SVGNode;
use SVG\Nodes\SVGNodeContainer;
use SVG\SVG;

class SVGElementReplacer implements Replacer
{
    /**
     * @param Element $placeholder
     * @param SVG $input
     */
    public function replace(Element $placeholder, $input)
    {
        /** @var SVGNodeContainer $parent */
        $parent = $placeholder->getParent();

        /** @var SVGNode $placeholderDocumentFragment */
        $placeholderDocumentFragment = $placeholder->getValue();

        $parent->setChild($placeholderDocumentFragment, $input->getDocument());
    }
}