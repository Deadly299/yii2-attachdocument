<?php
namespace deadly299\attachdocument\widgets;

use yii;

class AddDocument extends \yii\base\Widget
{
    public $model = null;
    public $uploadsPath = '';
    public $allowExtensions = ['doc', 'docx', 'pdf'];
    public $inputName = 'documetFiles';
    public $action = '/attachdocument/document/remove-file';

    public function init()
    {
        if (empty($this->uploadsPath))
            $this->uploadsPath = yii::$app->getModule('attachdocument')->documentsStorePath;

        \deadly299\attachdocument\assets\WidgetAsset::register($this->getView());
    }

    public function run()
    {
        return Yii::$app->document->renderDocuments($this->model);
    }
}