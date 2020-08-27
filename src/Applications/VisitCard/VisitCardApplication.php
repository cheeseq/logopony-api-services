<?php
declare(strict_types=1);

namespace App\Applications\VisitCard;

use App\Applications\AbstractApplication;
use App\Applications\VisitCard\Processors\TemplateProcessor;
use App\Applications\VisitCard\Processors\ZipProcessor;
use App\ValidationRules\IsDirectoryRule;
use App\ValidationRules\IsFileOrDirRule;
use Psr\EventDispatcher\EventDispatcherInterface;
use Rakit\Validation\Validator;

class VisitCardApplication extends AbstractApplication
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct($config, $userRequest, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($config, $userRequest);
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function getConfigValidationRules(Validator $validator): array
    {
        $validator->addValidator('is_directory', new IsDirectoryRule());
        $validator->addValidator('is_file_or_dir', new IsFileOrDirRule());

        return [
            'outputDir' => 'required|is_directory',
            'templates' => 'required|array|min:1',
            'templates.*.path' => 'required|is_file_or_dir',
            'templates.*.type' => 'in:SVG',
            'templates.*.elements' => 'required|array|min:1',
            'templates.*.elements.*.type' => 'required',
            'templates.*.elements.*.id' => 'required',
        ];
    }

    protected function getRequestValidationRules(Validator $validator): array
    {
        //@todo validate colors
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable',
            'url' => 'nullable',
            'position' => 'nullable',
            'address' => 'nullable',
            'country' => 'nullable',
            'logo' => 'required|array',
            'logo.original' => 'required',
            'logo.black' => 'required',
            'logo.textColor' => 'nullable',
            'icon' => 'array|nullable',
            'icon.original' => 'nullable',
            'icon.black' => 'nullable',
            'color' => 'required|array',
            'color.type' => 'required|in:color,gradient',
            'color.value' => function ($value) {
                return is_array($value)
                    ? array_key_exists("start", $value) && array_key_exists("end", $value)
                    : !empty($value);
            }
        ];
    }

    public function run()
    {
        $templateGenerator = new TemplateProcessor($this->config['outputDir'], $this->request, $this->eventDispatcher);
        $resultPaths = $templateGenerator->run($this->config['templates']);

        $zipper = new ZipProcessor($this->config['outputDir']);
        $archiveFilePath = $zipper->run($resultPaths);

        return $archiveFilePath;
    }


}
