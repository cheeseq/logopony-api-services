<?php
namespace App\Applications\VisitCard;

interface Template
{
    public function parseFile(string $filePath);

    public function toFile(string $filePath);

    public function getTemplate();

    public function setTemplate($template);

    public function findElement($id): ?Element;
}
