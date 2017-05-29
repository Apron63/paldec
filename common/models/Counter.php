<?php

namespace common\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "paldec_counter".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $num
 */
class Counter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paldec_counter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'num', 'date_verification'], 'required'],
            [['model_id'], 'integer'],
            ['company_id', 'safe'],
            [['num'], 'string', 'max' => 25],
            ['date_verification', 'filter', 'filter' => function ($value) {
                return strtotime($value);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Организация',
            'model_id' => 'Модель',
            'num' => 'Номер',
            'date_verification' => 'Поверка',
        ];
    }
    /*******************************************************************************************/
    public function getModelId()
    {
        return $this->hasOne(CounterModel::className(), ['id' => 'model_id']);
    }

    public function getModelName()
    {
        return $this->modelId ? $this->modelId->name : 'Не отпределено';
    }

    public function getModelList()
    {
        $droptions = CounterModel::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'name');
    }
    /*******************************************************************************************/
    public function getCompanyId()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getCompanyName()
    {
        return $this->companyId ? $this->companyId->short_name : 'Не отпределено';
    }
}
