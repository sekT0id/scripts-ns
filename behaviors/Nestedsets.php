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
    * ��������� �������� ������� �� id ��������
    */
    public function add_child($parent_id){
    	$child= new Nestedsets;
		//�������������� �������� ����� �� ����������
		//������� �������� ��� ����� �������
    	if('root'===$parent_id){
        	$child->left =0;
        	$child->right=1;
        	$child->level=0;
        	$child->insert();
    	}
   	    else{
			//���������� ��������� ������������� ��������
			$parent_attributes = new Nestedsets();
			$parent_attributes=Nestedsets::find()->where(['id' => $parent_id])->one();

			//�������� ����� � ������, ��� ���������� ������ ��������
			Nestedsets::updateAllCounters(['right' => 2],['>=','right',$parent_attributes->right]);
			Nestedsets::updateAllCounters(['left' => 2],['>=','left',$parent_attributes->right]);

			//��������� ����� �������
        	$child->left = $parent_attributes->right;
        	$child->right= $parent_attributes->right+1;
        	$child->level= $parent_attributes->level+1;
        	$child->insert();
		}
    }

	/**
    * ���������� ������ ��������� �������
    */
    public function create_tree($depth=20){
		//������� ������� ������
		Yii::$app->db->createCommand("truncate table ".$this->tableName())->execute();

		//��������� ������ - ������� 0,1
		//�������������� ��� �������� �� ����������
		//������� �������� ����� �������
    	$this->add_child('root');

    	$root_attributes = new Nestedsets;
		//��������� ��������� �������� ������
		for($i=1;$i<$depth;$i++){
			//���������� ������� ����������� ������
			$root_attributes = Nestedsets::find()->where(['left' => 0])->one();

			//��������� ����������� �������� �������
			//� �������� ����� �������� ��������
			$posible_parrent=($root_attributes->right-1)/2+1;

			//������� ���������� �������� ��� ���������� ������ ��������
	        $random_parent=rand(1,$posible_parrent);

	        //��������� ����� ������� � ������
        	$this->add_child($random_parent);
		}
	}
}