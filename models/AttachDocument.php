<?php

namespace deadly299\attachdocument\models;

use Yii;
use deadly299\attachdocument\ModuleTrait;
/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $model
 * @property int $docs_id
 * @property string $name
 * @property string $file_path
 * @property string $file_name
 * @property int $created_at
 * @property int $updated_at
 */
class AttachDocument extends \yii\db\ActiveRecord
{
    use ModuleTrait;

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
            [['file_name', 'file_path', 'model', 'item_id'], 'required'],
            [['model', 'file_name', 'file_path', 'url_alias'], 'string', 'max' => 255],
            ['extension', 'string', 'max' => 10],
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
            'url_alias' => 'alias',
            'file_path' => 'path',
            'extension' => 'extension',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
