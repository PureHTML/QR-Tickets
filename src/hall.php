<?php

use Ease\Shared;
use Ease\TWB4\Container;
use Ease\TWB4\WebPage;
use PureOSC\ui\Hall;
use PureOSC\ui\HallEditor;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();
Shared::singleton()->loadConfig('../.env', true);

$oPage = new WebPage('Ticket Code Scanner');


$hallId = WebPage::getRequestValue('id', 'int');
$hallName = WebPage::getRequestValue('hall_name');

if (WebPage::isFormPosted() === false) {
    if (is_null($hallId) && isset($_SESSION['current_hall'])) {
        $hallId = intval($_SESSION['current_hall']);
    }
}

$haller = new Hall(empty($hallId) ? ['name'=> $hallName ] : $hallId , ['autoload' => true]);
$addSegment = WebPage::getRequestValue('add_segment');
$delSegment = WebPage::getRequestValue('del_segment');

if ($addSegment) {
    if ($haller->addSegment($addSegment)) {
    $oPage->redirect('hall.php?id=' . $hallId);
        exit();
    }
}
if ($delSegment) {
    $haller->delSegment($delSegment);
}

$hallName = WebPage::getRequestValue('hall_name');

if (WebPage::isFormPosted()) {
    $haller->dbsync(['name' => WebPage::getRequestValue('hall_name'), 'capacity' => WebPage::getRequestValue('hall_capacity')]);
    $_SESSION['current_hall'] = $haller->getMyKey();
} else {


    $hallId = array_key_exists('current_hall', $_SESSION) ? $_SESSION['current_hall'] : null;
}


$languages = tep_get_languages();
$languages_array = [];
$languages_selected = DEFAULT_LANGUAGE;
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = ['id' => $languages[$i]['code'], 'text' => $languages[$i]['name']];
    if ($languages[$i]['directory'] == $language) {
        $languages_selected = $languages[$i]['code'];
    }
}
$editor = new HallEditor($haller);

$editor->finalize();

echo new Container($editor);

echo $oPage->draw();
