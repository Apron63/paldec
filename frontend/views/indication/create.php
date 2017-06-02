<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Indication */

$this->title = 'Добавить показание';
//$this->params['breadcrumbs'][] = ['label' => 'Indications', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
