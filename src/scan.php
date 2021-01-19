<?php

namespace QRScan\Ui;

use Ease\Html\InputTextTag;
use Ease\TWB4\Container;
use Ease\TWB4\Form;
use Ease\TWB4\Label;
use Ease\TWB4\WebPage;

require_once __DIR__ . '/../vendor/autoload.php';

\Ease\Shared::singleton()->loadConfig('../.env', true);


$haller = new \PureOSC\Hall(WebPage::getRequestValue('id'));

$oPage = new WebPage('Ticket Code Scanner '.$haller->getDataValue('name'));


$container = new Container(new Label('info', WebPage::getRequestValue('code')));
$container->addItem(new Form([], [], new InputTextTag('code', '', ['autofocus'])));


$hallWidget = $container->addItem(new \PureOSC\ui\Hall($haller->getDataValue('name'), $haller->getSegments()));
$hallWidget->addCSS('.chair_place {width: 20px}');

//$container->addItem( new \PureOSC\ui\HallSelect() );

$oPage->addItem($container);

echo $oPage->draw();
