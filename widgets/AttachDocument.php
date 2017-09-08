<?php
namespace deadly299\attachdocument\widgets;

use yii;
use deadly299\attachdocument\models\Document;


class AttachDocument extends \yii\base\Widget
{
    public $model = null;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $model = $this->model;
//        $documents = Documents::find()->where(['model' => $model::className(), 'item_id' => $this->model->id])->all();
        $documents = Documents::find()->all();

        foreach ($documents as $document) {
            $this->row .= $this->_row($document);
        }
    }

    private function _row($document)
    {
        return $this->render('_item', ['document' => $document]);
    }

}