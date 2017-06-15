<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$dropdown = <<<DROPDOWN
<div class="dropdown">
    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Операции
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="counter/create">Создать счетчик</a></li>
        <li><a href="indication/mass-input">Массовый ввод</a></li>
        <li><a id="act-potr111" href="">Акт потребления</a></li>
  </ul>
</div>
DROPDOWN;

?>
<p><?= $name?></p>

<?= GridView::widget([
    'dataProvider' => $dataProviderA,
    //'filterModel' => $searchModelA,
    'id' => 'counter-table',
    'rowOptions' => function ($model, $key, $index, $grid) {
        if ($model->arh) {
            return ['class' => 'arh-counter'];
        } else {
            return;
        }
    },
    'columns' => [
        [
            'attribute' => 'modelName',
            'label' => 'Модель',
        ],
        //'modelName',
        'num',
        'place',
        [
            'attribute' => 'date_verification',
            'value' => function($model){
                return date('d.m.Y', $model->date_verification);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Html::a('Создать', ['/counter/create', 'company-id' => 33], ['class' => 'btn btn-success', 'title' => 'Добавить новый счетчик']),
            //'header' => $dropdown,
            'template' => '{update} {delete} {indication}',
            'contentOptions' => [
                'width' => 100,
            ],
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                        'title' => 'Редактировать',
                        'class'=>'btn btn-primary btn-xs',
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => 'Удалить',
                        'class'=>'btn btn-primary btn-xs',
                        'data-method' => 'post',
                        'data-confirm' => 'Действительно удалить счетчик?',
                    ]);
                },
                'indication' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-dashboard"></span>', 'indication/index?id=' . $model->id, [
                        'title' => 'Показания',
                        'class'=>'btn btn-primary btn-xs',
                    ]);
                },
            ],
        ],
    ],
]); ?>