<?php


namespace App\Applications\VisitCard\Events;


use App\Applications\VisitCard\Element;
use App\Applications\VisitCard\Template;
use Symfony\Contracts\EventDispatcher\Event;

class ValueObtainedEvent extends Event
{
    private $value;
    private array $placeholderItem;
    private Template $template;
    private Element $placeholder;

    /**
     * ValueObtainedEvent constructor.
     * @param $value
     * @param array $type
     * @param Template $template
     * @param Element $placeholder
     */
    public function __construct($value, array $type, Template $template, Element $placeholder)
    {
        $this->value = $value;
        $this->template = $template;
        $this->placeholderItem = $type;
        $this->placeholder = $placeholder;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getPlaceholderItem(): array
    {
        return $this->placeholderItem;
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return $this->template;
    }

    /**
     * @return Element
     */
    public function getPlaceholder(): Element
    {
        return $this->placeholder;
    }

    /**
     * @param Element $placeholder
     */
    public function setPlaceholder(Element $placeholder): void
    {
        $this->placeholder = $placeholder;
    }
}