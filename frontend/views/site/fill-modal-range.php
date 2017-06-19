<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
//use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
?>
<?= DateRangePicker::widget([
    'name' => 'date',
    'value' => date('d.m.Y'),
    'nameTo' => 'dateTo',
    'valueTo' => date('d.m.Y'),
    'labelTo' => 'по',
    'language' => 'ru',

    'options' => [
        'id' => 'x-datepicker',
    ],
    'optionsTo' => [
        'id' => 'y-datepicker',
    ],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy',
    ]
]);?>
