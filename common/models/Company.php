<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paldec_company".
 *
 * @property integer $id
 * @property string $short_name
 * @property string $name
 * @property string $inn
 * @property string $kpp
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paldec_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'inn', 'kpp'], 'required'],
            [['name', 'short_name', 'inn', 'kpp'], 'string'],
            ['short_name', 'unique', 'message' => 'Такая организация уже существует!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_name' => 'Сокращенное наименование',
            'name' => 'Полное наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
        ];
    }
}
