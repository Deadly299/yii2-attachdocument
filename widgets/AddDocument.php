<?php
namespace deadly299\attachdocument\widgets;

use deadly299\attachdocument\models\AttachDocument;
use yii;


class AddDocument extends \yii\base\Widget
{
    public $model = null;
    public $row = null;
    public $uploadsPath = '';
    public $allowExtensions = ['doc', 'docx', 'pdf'];
    public $inputName = 'documetFiles';
    private $doResetImages = true;

    public function init()
    {
        if (empty($this->uploadsPath)) {
            $this->uploadsPath = yii::$app->getModule('attachdocument')->documentsStorePath;
        }

    }

    public function run()
    {

        $model = $this->model;

        $documents = AttachDocument::find()->where([
            'model' => substr($model::className(), strrpos($model::className(), '\\') + 1),
            'item_id' => $this->model->id
        ])->all();

        $this->row .= $this->_row($documents, $model);


        return $this->row;
    }

    public function getRow()
    {
        return $this->row;
    }

    private function _row($documents, $model)
    {
        return $this->render('_item', ['documents' => $documents, 'model' => $model]);
    }

}