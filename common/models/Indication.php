<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paldec_indication".
 *
 * @property integer $id
 * @property integer $counter_id
 * @property integer $date
 * @property integer $value
 */
class Indication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paldec_indication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['counter_id', 'date', 'value'], 'required'],
            [['counter_id', 'value'], 'integer'],
            ['date', 'filter', 'filter' => function ($value) {return strtotime($value);}],
            [['counter_id', 'date'], 'unique', 'targetAttribute' => ['counter_id', 'date'], 'message' => 'Показания на указанную дату уже введены!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'counter_id' => 'Счетчик',
            'date' => 'Дата',
            'value' => 'Значение',
        ];
    }

    /******************************************************************************************************************/
    public function getCounterId()
    {
        return $this->hasOne(Counter::className(), ['id' => 'counter_id']);
    }

    public function getCounterNum()
    {
        return $this->counterId ? $this->counterId->num : 'Не отпределено';
    }

    public function getCounterModel()
    {
        return $this->counterId ? $this->counterId->modelName : 'Не отпределено';
    }
}
