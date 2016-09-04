<?php
namespace app\extended\models;

use yii\base\Model;
use yii\web\Response;
use yii\web\UploadedFile;
/**
 * app\models
 */
class Form extends Model
{
    public $id;
    public $secure;
    public $path;
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
                'text',
                'secure',
                'path',
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
