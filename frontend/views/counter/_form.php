<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num')->textInput(['autofocus' => 'on', 'maxlength' => 25,'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'model_id')->dropDownList($model->modelList)?>

    <div class="form-group">

        <?= Html::a('Добавить модель',
            $model->isNewRecord ? ['/counter/add-model-from-create', 'company_id' => $model->company_id] : ['/counter/add-model-from-update', 'id' => $model->id],
            ['class' => 'btn btn-success']
        )?>
    </div>

    <?= $form->field($model, 'place')->textInput(['maxlength' => 25, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'seal')->textInput(['maxlength' => 25, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'date_verification')->widget(DatePicker::className(), [
        'inline' => false,
        'language' => 'ru',
        'template' => '{addon}{input}',
        'options' => [
                'value' => date('d.m.Y', $model->date_verification),
        ],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);?>

    <?= $form->field($model, 'date_made')->widget(DatePicker::className(), [
        'inline' => false,
        'language' => 'ru',
        'template' => '{addon}{input}',
        'options' => [
            'value' => date('d.m.Y', $model->date_made),
        ],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);?>

    <?= $form->field($model, 'date_set')->widget(DatePicker::className(), [
        'inline' => false,
        'language' => 'ru',
        'template' => '{addon}{input}',
        'options' => [
            'value' => date('d.m.Y', $model->date_set),
        ],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
