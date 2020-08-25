<?php

namespace Modules\VisitCard;

use App\Modules\VisitCard\Events\ValueObtainedEvent;
use App\Modules\VisitCard\SVG\Listeners\BackgroundColorListener;
use App\Modules\VisitCard\SVG\Listeners\LogoListener;
use App\Modules\VisitCard\VisitCardApplication;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class VisitCardGeneratorTest extends TestCase
{
    /**
     * @var mixed
     */
    private $conf;
    private $orig;
    private $black;

    protected function setUp(): void
    {
        parent::setUp();
        $this->conf = require __DIR__ . '/../../../src/Modules/VisitCard/config.php';
        $this->orig = __DIR__ . '/../../tests/orig.svg';
        $this->black = __DIR__ . '/../../tests/black.svg';
    }


    public function testGradient()
    {
        $files = glob($this->conf['outputDir'] . '/*'); // get all file names
        if ($files) {
            foreach ($files as $file) { // iterate files
                if (is_file($file)) {
                    unlink($file);
                } // delete file
            }
        }
        $bgColorListener = new BackgroundColorListener();
        $incomingSvgUrlListener = new LogoListener();

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(ValueObtainedEvent::class, [$bgColorListener, 'onValueObtained']);
        $dispatcher->addListener(ValueObtainedEvent::class, [$incomingSvgUrlListener, 'onValueObtained']);
        $generator = new VisitCardApplication($this->conf, [
            'name' => 'stepqa',
            'surname' => 'ivanov',
            'logo' => ['original' => $this->orig, 'black' => $this->black],
            'color' => ['type' => 'gradient', 'value' => ['start' => '#ffffff', 'end' => '#000000']]
        ], $dispatcher);
        $zip = $generator->run();
        self::assertFileExists($zip);
        self::assertEquals(mime_content_type($zip), 'application/zip');
    }

    public function testGenerate()
    {
        $files = glob($this->conf['outputDir'] . '/*'); // get all file names
        if ($files) {
            foreach ($files as $file) { // iterate files
                if (is_file($file)) {
                    unlink($file);
                } // delete file
            }
        }
        $incomingSvgUrlListener = new LogoListener();

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(ValueObtainedEvent::class, [$incomingSvgUrlListener, 'onValueObtained']);
        $generator = new VisitCardApplication($this->conf, [
            'name' => 'stepqa',
            'surname' => 'ivanov',
            'logo' => ['original' => $this->orig, 'black' => $this->black],
            'color' => ['type' => 'color', 'value' => '#ffffff']
        ], $dispatcher);
        $zip = $generator->run();
        self::assertFileExists($zip);
        self::assertEquals(mime_content_type($zip), 'application/zip');
    }
}
