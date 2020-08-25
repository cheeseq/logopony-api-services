<?php

use App\Modules\VisitCard\Events\ValueObtainedEvent;
use App\Modules\VisitCard\SVG\Listeners\BackgroundColorListener;
use App\Modules\VisitCard\SVG\Listeners\LogoListener;
use App\Modules\VisitCard\VisitCardApplication;
use Bramus\Router\Router;
use Symfony\Component\EventDispatcher\EventDispatcher;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$incomingSvgUrlListener = new LogoListener();
$bgListener = new BackgroundColorListener();

$dispatcher = new EventDispatcher();
$dispatcher->addListener(ValueObtainedEvent::class, [$incomingSvgUrlListener, 'onValueObtained']);
$dispatcher->addListener(ValueObtainedEvent::class, [$bgListener, 'onValueObtained']);

$router->post('/business-cards', function () use ($dispatcher) {
    $result = ['success' => false];

    try {
        $parsedRequest = json_decode(file_get_contents('php://input'), true);
        $config = require __DIR__ . '/../src/Modules/VisitCard/config.php';

        $generator = new VisitCardApplication($config, $parsedRequest, $dispatcher);
        $zip = $generator->run();

        $result['success'] = true;
        $result['zip'] = $zip;
    } catch (Exception $e) {
        $result['error'] = $e->getMessage();
    } finally {
        echo json_encode($result);
        exit();
    }
});

$router->run();