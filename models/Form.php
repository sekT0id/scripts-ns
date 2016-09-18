<?php
namespace app\models;

use yii\base\Model;
/**
 * app\models
 */
class Form extends Model
{
    public $id;
    public $parentId;

    public $name;
    public $phone;

    public $text;
    public $data;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {

        return [
            [[
                'name',
                'phone',
            ],
                'required'],
            [[
                'name',
                'phone',
                'data',
                'parentId',
                'text',
                'id',
            ],
                'string'],
        ];
    }

public function attributeLabels()
    {
        return [
            'name'  => 'Наименование',
            'phone' => 'Номер телефона',

            'data'  => 'Дополнительная информация',
            'text'  => 'Текст',
        ];
    }
    public function init()
    {
        parent::init();
    }
}
