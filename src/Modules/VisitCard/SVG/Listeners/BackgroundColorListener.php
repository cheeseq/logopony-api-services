<?php


namespace App\Modules\VisitCard\SVG\Listeners;


use App\Modules\VisitCard\Events\ValueObtainedEvent;
use SVG\Nodes\SVGGenericNodeType;
use SVG\Nodes\SVGNode;
use SVG\SVG;

class BackgroundColorListener
{
    /** @noinspection PhpUnused */
    public function onValueObtained(ValueObtainedEvent $event)
    {
        $placeholderConfigItem = $event->getPlaceholderItem();

        if ($placeholderConfigItem['type'] != 'color') {
            return;
        }

        $input = $event->getValue();
        $template = $event->getTemplate();
        /** @var SVG $svg */
        $svg = $template->getTemplate();

        if ($input['type'] == 'color') {
            $event->setValue($input['value']);
        } elseif ($input['type'] == 'gradient') {
            $coords = $this->getGradientCornersCoords($input['value']['direction']);
            $gradientNode = $this->createGradientNode($coords);

            $startOffsetNode = $this->createGradientStartOffsetNode($input['value']['start']);
            $stopOffsetNode = $this->createGradientStopOffsetNode($input['value']['end']);

            $gradientNode->addChild($startOffsetNode);
            $gradientNode->addChild($stopOffsetNode);

            $svg->getDocument()->addChild($gradientNode, 0);

            $event->setValue("url(#linear-gradient)");
        }
    }

    private function createGradientNode(array $coords): SVGNode
    {
        $gradientNode = new SVGGenericNodeType("linearGradient");
        $gradientNode->setAttribute("id", "linear-gradient");
        $gradientNode->setAttribute("gradientUnits", "objectBoundingBox");
        $gradientNode->setAttribute("x1", $coords['x1']);
        $gradientNode->setAttribute("y1", $coords['y1']);
        $gradientNode->setAttribute("x2", $coords['x2']);
        $gradientNode->setAttribute("y2", $coords['y2']);

        return $gradientNode;
    }

    private function createGradientStartOffsetNode(string $startColor): SVGNode
    {
        $startOffsetNode = new SVGGenericNodeType("stop");
        $startOffsetNode->setAttribute("offset", 0);
        $startOffsetNode->setAttribute("stop-color", $startColor);

        return $startOffsetNode;
    }

    private function createGradientStopOffsetNode(string $stopColor): SVGNode
    {
        $stopOffsetNode = new SVGGenericNodeType("stop");
        $stopOffsetNode->setAttribute("offset", 1);
        $stopOffsetNode->setAttribute("stop-color", $stopColor);

        return $stopOffsetNode;
    }

    private function getGradientCornersCoords($direction): array
    {
        $coords = [
            'x1' => 0,
            'y1' => 0.5,
            'x2' => 1,
            'y2' => 0.5,
        ];

        if ($direction === 'bottom') {
            $coords = [
                'x1' => 0.5,
                'y1' => 0,
                'x2' => 0.5,
                'y2' => 1,
            ];
        }

        return $coords;
    }
}