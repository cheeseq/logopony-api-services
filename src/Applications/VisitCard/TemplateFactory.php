<?php


namespace App\Applications\VisitCard;


use App\Applications\VisitCard\SVG\SVGTemplate;
use InvalidArgumentException;

class TemplateFactory
{
    public static function getTemplateMap(): array
    {
        return [
            'SVG' => SVGTemplate::class
        ];
    }

    public static function createTemplate($filePath, $type): Template
    {
        if (!$type) {
            //@todo resolve by file extension
        }

        if (!self::getTemplateMap()[strtoupper($type)]) {
            throw new InvalidArgumentException();
        }

        $classname = self::getTemplateMap()[$type];

        $template = new $classname();
        $template->parseFile($filePath);

        return $template;
    }
}