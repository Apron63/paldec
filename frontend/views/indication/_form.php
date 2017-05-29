<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Indication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indication-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'inline' => false,
        'language' => 'ru',
        'template' => '{addon}{input}',
        'options' => [
            'value' => date('d-m-Y', $model->date),
        ],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy',
        ]
    ]);?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
