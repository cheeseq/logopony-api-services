<?php


namespace App\Applications\VisitCard\SVG;


use App\Applications\VisitCard\Element;
use App\Applications\VisitCard\Template;
use SVG\SVG;

class SVGTemplate implements Template
{
    private SVG $template;

    public function getTemplate(): SVG
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function parseFile(string $filePath)
    {
        $this->setTemplate(SVG::fromFile($filePath));
    }

    public function toFile(string $filePath)
    {
        file_put_contents($filePath, $this->getTemplate());
    }

    public function findElement($id): ?Element
    {
        $node = $this->template->getDocument()->getElementById($id);
        if ($node == null) {
            return null;
        }
        return new SVGElement($node, $this->getTemplate()->getDocument());
    }
}
