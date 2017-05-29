<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = 'Добавить организацию';
?>
<div class="company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
