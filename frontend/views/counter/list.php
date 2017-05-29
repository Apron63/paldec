<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

?>
<p><?= $name?></p>

<?= GridView::widget([
    'dataProvider' => $dataProviderA,
    'filterModel' => $searchModelA,
    'id' => 'counter-table',
    'columns' => [
        [
            'attribute' => 'modelName',
            'label' => 'Модель',
        ],
        //'modelName',
        'num',
        [
            'attribute' => 'date_verification',
            'value' => function($model){
                return date('d.m.Y', $model->date_verification);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Html::a('Создать', ['/counter/create', 'company-id' => 33], ['class' => 'btn btn-success', 'title' => 'Добавить новый счетчик']),
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
                        'class'=>'btn btn-primary btn-xs get-counters',
                        //'data-id' => $model->id,
                    ]);
                },
            ],
        ],
    ],
]); ?>