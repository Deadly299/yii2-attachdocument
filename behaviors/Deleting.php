<?php
namespace deadly299\attachdocument\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use deadly299\attachdocument\models\AttachDocument;

class Deleting extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'delete_documents',
        ];
    }

    public function deleteDocuments()
    {
        $model = $this->owner;
        $documents = $this->getDocuments($model);

        foreach ($documents as $document)
            $this->deleteDocument($document);
    }

    public function getDocuments($model)
    {
        if(empty($model))
            return null;

        return AttachDocument::find()->where([
            'item_id' => $model->id,
            'model' => $model::className(),
        ])->all();
    }

    private function deleteDocument($model)
    {
        $model = AttachDocument::findOne($model->id);
        if($model)
            $model->delete();
    }
}