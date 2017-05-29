<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paldec_counter_model".
 *
 * @property integer $id
 * @property string $name
 * @property integer $period
 */
class CounterModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paldec_counter_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'period'], 'required'],
            [['period'], 'integer'],
            [['name'], 'string', 'max' => 25],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'period' => 'Период поверки',
        ];
    }
}
