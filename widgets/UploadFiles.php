<?php

namespace deadly299\attachdocument\widgets;

use kartik\file\FileInput;
use yii;
use yii\helpers\Html;
use yii\helpers\Url;

class UploadFiles extends \yii\base\Widget
{
    public $model = null;
    public $fileInputPluginLoading = true;
    public $fileInputPluginOptions = [];
    public $label = null;
    public $dataOptionsLink = [];

    public function init()
    {
        if (!$this->label) {
            $this->label = yii::t('common', 'Documents');
        }

        \deadly299\attachdocument\assets\WidgetAsset::register($this->getView());
    }

    public function run()
    {
        $docsUl = null;
        if ($this->model->hasDocument()) {
            $elements = $this->model->getDocuments();
            $docsUl = Html::ul(
                $elements, ['item' => function ($item) {
                return $this->row($item);
            },
                'class' => 'deadly299-gallery'
            ]);
        }
        return Html::tag('div', $this->label . $docsUl . $this->getFileInput());
    }

    private function row($document)
    {
        $delete = Html::a( '✖', null,[
            'data-action' => Url::toRoute(['/attachDocument/document/remove-file', 'id' => $document->id]),
            //'class' => 'delete',
            'data-role' => 'remove-document-deadly299'
        ]);

        return Html::tag('li', $document->file_name .' '. $delete, []);
    }

    private function getFileInput()
    {
        return FileInput::widget([
            'name' => $this->model->getInputName() . '[]',
            'options' => [
                'accept' => 'image/*',
                'multiple' => $this->model->getMode() == 'multiple',
            ],
            'pluginOptions' => $this->fileInputPluginOptions,
            'pluginLoading' => $this->fileInputPluginLoading
        ]);
    }

}
