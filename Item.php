<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return null|Item
     */
    public function getParent(){

        if(empty ($this->parent_id)) return null;
        return self::findOne($this->parent_id);

    }

    /**
     * @param Item $model
     * @param array $parents
     */
    public static function getParentsRecursive(Item $model, array &$parents) {

        if($parent = $model->getParent()) {

            $parents[] = $parent;
            self::getParentsRecursive($parent, $parents);
        }
    }

    /**
     * @param Item $model
     * @return array
     */
    public static function getAllParents(Item $model)
    {
        $parents = [];
        self::getParentsRecursive($model, $parents);

        return $parents;
    }
}
