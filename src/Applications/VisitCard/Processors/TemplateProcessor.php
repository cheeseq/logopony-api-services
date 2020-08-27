<?php

declare(strict_types=1);
namespace App\Applications\VisitCard\Processors;


use App\Applications\Helpers;
use App\Applications\VisitCard\Element;
use App\Applications\VisitCard\Events\ValueObtainedEvent;
use App\Applications\VisitCard\Template;
use App\Applications\VisitCard\TemplateFactory;
use Psr\EventDispatcher\EventDispatcherInterface;

class TemplateProcessor
{
    private string $outputDir;
    private array $request;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(string $outputDir, array $request, EventDispatcherInterface $eventDispatcher)
    {
        $this->outputDir = $outputDir;
        $this->request = $request;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function run(array $templateSources)
    {
        $resultPaths = [];
        foreach ($templateSources as $templateSource) {
            $filePaths = $this->resolveFilePathsFromTemplateSource($templateSource);
            foreach ($filePaths as $filePath) {
                //@todo validate file path here?
                $template = TemplateFactory::createTemplate($filePath, $templateSource['type']);
                $this->replaceTemplatePlaceholders($template, $templateSource['elements']);

                $templateFilePath = $this->outputDir . '/' . Helpers::randomString() . '.svg';
                $template->toFile($templateFilePath);
                $resultPaths[] = $templateFilePath;
            }
        }

        return $resultPaths;
    }

    private function resolveFilePathsFromTemplateSource($templateSource)
    {
        $result = [];
        $path = $templateSource['path'];
        if (is_file($path)) {
            $result[] = $templateSource['file'];
        } else {
            //@todo use glob
            $result = scandir($templateSource['path']);
            $result = array_slice($result, 2);
            $result = array_map(function ($p) use ($path) {
                return $path . '/' . $p;
            }, $result);
        }
        return $result;
    }


    public function replaceTemplatePlaceholders(Template $template, array $placeholders)
    {
        foreach ($this->request as $requestField => $inputValue) {
            if (!array_key_exists($requestField, $placeholders)) {
                continue;
            }

            $placeholderConfigItem = $placeholders[$requestField];

            /** @var Element $placeholder */
            $placeholder = $template->findElement($placeholderConfigItem['id']);

            if ($placeholder == null) {
                continue;
            }

            $event = new ValueObtainedEvent($inputValue, $placeholderConfigItem, $template, $placeholder);
            $this->eventDispatcher->dispatch($event);

            $inputValue = $event->getValue();

            $placeholder->replaceBy($inputValue, $placeholderConfigItem['type']);
        }
    }
}