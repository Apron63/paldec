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

    <h1><?= Html::encode($this->title . ':' . $counter->num) ?></h1>
    <p><?= Html::encode('Модель : ' . $counter->modelName . ' Поверка : ' . date('d.m.Y', $counter->date_verification))?></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать показание', ['create', 'counter_id' => $counter->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Вернуться к списку счетчиков', ['back', 'counter_id' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'counter_id',
            'date',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
