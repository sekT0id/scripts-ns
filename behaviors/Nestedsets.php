<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * This is the model class for table "nestedsets".
 *
 * @property integer $id
 * @property integer $left
 * @property integer $right
 * @property integer $level
 */
class Nestedsets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nestedsets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['left', 'right', 'level'], 'required'],
            [['left', 'right', 'level'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'left' => 'Left',
            'right' => 'Right',
            'level' => 'Level',
        ];
    }

	/**
    * Добавляет дочерний элемент по id родителя
    */
    public function add_child($parent_id){
    	$child= new Nestedsets;
		//зауниверсалить создание корня не получилось
		//поэтому добавляю его явным образом
    	if('root'===$parent_id){
        	$child->left =0;
        	$child->right=1;
        	$child->level=0;
        	$child->insert();
    	}
   	    else{
			//Начитываем параметры родительского элемента
			$parent_attributes = new Nestedsets();
			$parent_attributes=Nestedsets::find()->where(['id' => $parent_id])->one();

			//выделяем место в дереве, для добавления нового элемента
			Nestedsets::updateAllCounters(['right' => 2],['>=','right',$parent_attributes->right]);
			Nestedsets::updateAllCounters(['left' => 2],['>=','left',$parent_attributes->right]);

			//добавляем новый элемент
        	$child->left = $parent_attributes->right;
        	$child->right= $parent_attributes->right+1;
        	$child->level= $parent_attributes->level+1;
        	$child->insert();
		}
    }

	/**
    * Генерируем дерево заданного размера
    */
    public function create_tree($depth=20){
		//очищаем таблицу дерева
		Yii::$app->db->createCommand("truncate table ".$this->tableName())->execute();

		//добавляем корень - элемент 0,1
		//зауниверсалить его создание не получилось
		//поэтому добавляю явным образом
    	$this->add_child('root');

    	$root_attributes = new Nestedsets;
		//добавляем остальные элементы дерева
		for($i=1;$i<$depth;$i++){
			//начитываем текущую размерность дерева
			$root_attributes = Nestedsets::find()->where(['left' => 0])->one();

			//вычисляем максимально возожный элемент
			//к которому можно добавить дочерний
			$posible_parrent=($root_attributes->right-1)/2+1;

			//находим случайного родителя для добавления нового элемента
	        $random_parent=rand(1,$posible_parrent);

	        //добавляем новый элемент в дерево
        	$this->add_child($random_parent);
		}
	}
}