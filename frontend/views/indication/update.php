<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Indication */

$this->title = 'Редактирование показаний: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Indications', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="indication-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
