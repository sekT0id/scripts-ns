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
    public $clientId;

    public $name;
    public $phone;

    public $text;
    public $comment;
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
                'clientId',
                'text',
                'comment',
                'id',
            ],
                'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'     => 'Наименование',
            'phone'    => 'Номер телефона',
            'data'     => 'Дополнительная информация',
            'text'     => 'Текст',
            'comment'  => 'Оставить комментарий',
        ];
    }
}
