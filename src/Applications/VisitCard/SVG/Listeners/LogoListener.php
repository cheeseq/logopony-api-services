<?php


namespace App\Applications\VisitCard\SVG\Listeners;


use App\Applications\VisitCard\Events\ValueObtainedEvent;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\Nodes\SVGNode;
use SVG\SVG;

class LogoListener
{
    /** @noinspection PhpUnused */
    public function onValueObtained(ValueObtainedEvent $event)
    {
        $placeholderConfigItem = $event->getPlaceholderItem();
        if ($placeholderConfigItem['type'] != 'logo' && $placeholderConfigItem['type'] != 'color') {
            return;
        }

        $logo = $event->getValue();
        $logo = $this->detectVersion($logo);

        //@todo check if url, if file exists e.t.c.
        $logo = SVG::fromFile($logo);

        $this->fitSizeAndPosition($logo->getDocument(), $event->getPlaceholder()->getValue());

        $event->setValue($logo);
    }

    public function fitSizeAndPosition(SVGDocumentFragment $logo, SVGNode $placeholder)
    {
        $widthRatio = 1.3;
        $logo->setHeight($placeholder->getHeight());
        $logo->setWidth($placeholder->getWidth() * $widthRatio);
        $compensation = ($logo->getWidth() - $placeholder->getWidth()) / 2;

        $logo->setAttribute("x", $placeholder->getAttribute("x") - $compensation);
        $logo->setAttribute("y", $placeholder->getAttribute("y"));
    }

    public function detectVersion($logo)
    {
        $textColor = $logo['textColor'] ?? '#ffffff';
        $textColorRGB = $this->hexToRGB($textColor);

        $contrast = $this->contrastToWhite($textColorRGB);
        return $contrast <= 2.2 ? $logo['black'] : $logo['original'];
    }

    private function contrastToWhite(array $rgbColor)
    {
        return $this->contrast([255, 255, 255], $rgbColor);
    }

    private function contrast(array $rgb1, array $rgb2)
    {
        return ($this->luminance($rgb1) + 0.05) / ($this->luminance($rgb2) + 0.05);
    }

    private function luminance(array $rgb)
    {
        $factors = array_map(function ($component) {
            $component /= 255;
            return $component <= 0.03928 ? $component / 12.92 : pow(($component + 0.055) / 1.055, 2.4);
        }, $rgb);

        return $factors[0] * 0.2126 + $factors[1] * 0.7152 + $factors[2] * 0.0722;
    }

    private function hexToRGB($hex)
    {
        //@todo check if arg is shorthand hex (like #fff) and convert to full hex
        $split_hex_color = str_split($hex, 2);
        return [
            hexdec($split_hex_color[0]),
            hexdec($split_hex_color[1]),
            hexdec($split_hex_color[2])
        ];
    }
}