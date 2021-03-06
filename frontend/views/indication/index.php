<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\IndicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Показания счетчика';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indication-index">

    <p>
        <?= Html::a('Вернуться', ['/'], ['class' => 'btn btn-primary']) ?>
    </p>

    <h1><?= Html::encode($this->title . ':' . $counter->num . ', ' . $counter->place) ?></h1>
    <p><?= Html::encode('Модель : ' . $counter->modelName . ' Поверка : ' . date('d.m.Y', $counter->date_verification))?></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'value' => function($model){
                    return date('d.m.Y', $model->date);
                },
            ],
            'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('Создать', ['/indication/create', 'counter_id' => $counter->id], ['class' => 'btn btn-success', 'title' => 'Добавить новое показание']),
                'template' => '{update} {delete}',
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
</div>
