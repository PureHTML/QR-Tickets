<?php

namespace QRScan\Ui;

use Ease\Html\InputTextTag;
use Ease\TWB4\Container;
use Ease\TWB4\Form;
use Ease\TWB4\Label;
use Ease\TWB4\WebPage;

require_once __DIR__ . '/../vendor/autoload.php';

\Ease\Shared::singleton()->loadConfig('../.env', true);

$oPage = new WebPage('Ticket Code Scanner');

$haller = new \PureOSC\Hall();
$hallInfo = $haller->getColumnsFromSQL(['id'], ['name'=>WebPage::getRequestValue('hall_name')]);

if($hallInfo){
   $oPage->redirect('scan.php?id='.$hallInfo[0]['id']);
} else {
   $oPage->redirect('index.php');
}
