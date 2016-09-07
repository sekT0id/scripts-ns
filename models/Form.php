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
    public $text;
    public $name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {

        return [
            [[
                'name',
            ],
                'required'],
            [[
                'name',
                'parentId',
                'text',
                'id',
            ],
                'string'],
        ];
    }

    public function init()
    {
        parent::init();
    }
}
