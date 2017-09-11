<?php

namespace deadly299\attachdocument\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $model
 * @property int $docs_id
 * @property string $name
 * @property string $file_name
 * @property int $created_at
 * @property int $updated_at
 */
class AttachDocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attach_document}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'created_at', 'updated_at'], 'integer'],
//            [['created_at', 'updated_at'], 'required'],
            [['model', 'file_name', 'file_path', 'url_alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'item_id' => 'Docs ID',
            'file_name' => 'File Name',
            'file_path' => 'path',
            'url_alias' => 'alias',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
