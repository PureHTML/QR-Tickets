<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PureOSC\ui;

use chillerlan\QRCode\QRCode;
use Ease\Html\ImgTag;
use Ease\Html\InputTextTag;
use Ease\Html\UlTag;
use Ease\TWB4\Form;
use Ease\TWB4\LinkButton;
use PureOSC\Hall;

/**
 * Description of HallsMenu
 *
 * @author vitex
 */
class HallsQRMenu extends UlTag {

    public function __construct(Hall $engine, $site) {
        parent::__construct(null, ['class' => 'list-group list-group-flush']);
        foreach ($engine->getAll() as $hall) {
            $this->addItemSmart(new LinkButton($site . '?id=' . $hall['id'], new ImgTag((new QRCode)->render($hall['name']), 'QR') . $hall['name'], 'warning', ['class' => 'btn-block']), ['class' => 'list-group-item']);
        }

        $qrform = new Form(['action' => 'scanjump.php'], []);
        $qrform->addInput(new InputTextTag('hall_name', '', ['placeholder' => _('Scan City code here ...'), 'autofocus']));
        $this->addItemSmart($qrform, ['class' => 'list-group-item']);
    }

}
