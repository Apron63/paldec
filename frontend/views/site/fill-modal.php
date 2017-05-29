<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
?>
<?= DatePicker::widget([
    'name' => 'Test',
    'language' => 'ru',
    'value' => date('d.m.Y'),
    'template' => '{addon}{input}',
    'options' => [
        'id' => 'x-datepicker',
    ],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy',
    ]
]);?>
