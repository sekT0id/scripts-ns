<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class NestedsetsForm extends Model
{
    public $depth;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['depth', 'required'],
        ];
    }
}
