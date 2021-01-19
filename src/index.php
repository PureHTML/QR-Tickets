<?php

use Ease\Shared;
use Ease\TWB4\Container;
use Ease\TWB4\Row;
use Ease\TWB4\WebPage as WebPage2;
use Ease\WebPage;
use PureOSC\Hall;
use PureOSC\ui\HallForm;
use PureOSC\ui\HallsEditor;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();
Shared::singleton()->loadConfig('../.env', true);

$oPage = new WebPage2('Ticket Code Scanner');

$hallName = WebPage::getRequestValue('hall_name');
$hallId = WebPage::getRequestValue('id', 'int');

if (WebPage::isFormPosted()) {

    $engine = new Hall(['name' => $hallName, 'capacity' => WebPage::getRequestValue('hall_capacity')]);
    $engine->dbsync();
    $_SESSION['current_hall'] = $engine->getMyKey();

    tep_redirect('hall.php?id=' . $engine->getMyKey());
    exit;
} else {
    $engine = new Hall(is_null($hallId) ? (array_key_exists('current_hall', $_SESSION) ? $_SESSION['current_hall'] : null ) : $hallId);

    $delId = WebPage::getRequestValue('del_hall', 'int');
    if ($delId) {
        $engine->deleteFromSQL($delId);
    }
}


$editor = new HallsEditor($engine);
$editor->addCSS('.chair_place {width: 15px}');

$hallRow = new Row();
$hallRow->addColumn(8, $editor);
$hallRow->addColumn(4, [ new PureOSC\ui\HallsQRMenu($engine, 'scan.php'),'<h2>New Hall</h2>', strval(new HallForm())]);

$container = new Container($hallRow);

$oPage->addItem($container);

echo $oPage->draw();
