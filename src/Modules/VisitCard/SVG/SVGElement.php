<?php


namespace App\Modules\VisitCard\SVG;


use App\Modules\VisitCard\Element;
use App\Modules\VisitCard\Replacer;
use App\Modules\VisitCard\SVG\Replacers\SVGBackgroundColorReplacer;
use App\Modules\VisitCard\SVG\Replacers\SVGElementReplacer;
use App\Modules\VisitCard\SVG\Replacers\SVGValueReplacer;
use SVG\Nodes\SVGNode;

class SVGElement implements Element
{
    private array $typeToReplacerMap = [
        'text' => SVGValueReplacer::class,
        'logo' => SVGElementReplacer::class,
        'icon' => SVGElementReplacer::class,
        'color' => SVGBackgroundColorReplacer::class
    ];

    private SVGNode $placeholderNode;
    private SVGNode $parent;

    public function __construct(SVGNode $placeholderNode, SVGNode $parent)
    {
        $this->placeholderNode = $placeholderNode;
        $this->parent = $parent;
    }

    public function getValue()
    {
        return $this->placeholderNode;
    }

    public function setValue($placeholderNode)
    {
        $this->placeholderNode = $placeholderNode;
    }

    public function getParent(): SVGNode
    {
        return $this->parent;
    }

    public function replaceBy($to, $type): bool
    {
        $class = $this->typeToReplacerMap[$type];
        /** @var Replacer $replacer */
        $replacer = new $class();
        $replacer->replace($this, $to);
        return true;
    }
}