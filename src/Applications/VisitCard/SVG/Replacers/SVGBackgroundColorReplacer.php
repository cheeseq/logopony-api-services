<?php


namespace App\Applications\VisitCard\SVG\Replacers;


class SVGBackgroundColorReplacer extends SVGAttributeReplacer
{

    protected function getAttributeName(): string
    {
        return 'fill';
    }
}