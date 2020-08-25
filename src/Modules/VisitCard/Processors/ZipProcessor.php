<?php


namespace App\Modules\VisitCard\Processors;


use ZipArchive;

class ZipProcessor
{
    private string $outputDir;
    private array $result = [];

    public function __construct($outputDir)
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    public function run(array $input)
    {
        $archive = new ZipArchive();
        $path = $this->outputDir . '/' . substr(str_shuffle(md5(microtime())), 0, 10) . '.zip';
        $archive->open($path, ZipArchive::CREATE);
        foreach ($input as $item) {
            $archive->addFile($item, basename($item));
        }
        $archive->close();
        $this->result[] = $path;
        return $path;
    }
}