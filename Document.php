<?php
namespace deadly299\attachdocument;

use deadly299\attachdocument\models\AttachDocument;
use tpmanc\imagick\Imagick;
use Yii;
use yii\base\Component;
use yii\bootstrap\Html;
use yii\helpers\Url;

class Document extends Component
{
    public $iconDoc = '';
    const EVENT_DOCUMENT_REMOVE = 'document_remove';
    const EVENT_DOCUMENT_RENAME = 'document_rename';
    const EVENT_DOCUMENT_UPLOAD = 'document_upload';

    public function documentRemove($data)
    {

    }

    public function documentRename($data)
    {

    }

    public function documentUpload($data)
    {

    }

    public function renderDocuments($model)
    {
        $content = null;
        $documents = $this->getDocuments($model);
        foreach ($documents as $document)
            $content .= $this->renderDocument($document);

        return Html::tag('div', $content, ['class' => 'deadly299-documents']);
    }

    public function getInputText($model)
    {
        $inputUpload = Html::textInput('newName', null, [
            'class' => 'form-control',
            'data-role' => 'intput-new-name-file-document',
            'data-id' => $model->id,
            'data-action' => Url::to(['/attachdocument/document/rename-file']),
            'placeholder' => 'Название файла',

        ]);
        $col = Html::tag('div', $inputUpload, ['class' => 'col-sm-12']);

        return Html::tag('div', $col, ['class' => 'row']);

    }

    public function renderDocument($model)
    {

        $imgs = Imagick::open($this->getModule()->iconDocumentPath);
        $img = Html::img($this->getModule()->iconDocumentPath, ['class' => 'img-doc']);
        $span = Html::tag('span', $model->url_alias);
        $p = Html::tag('p',$span ,['class' => 'doc-name']);
        $glyphiconRemove = Html::tag('i', null, [
            'class' => 'glyphicon glyphicon-remove',
            'data-role' => 'remove-document',
        ]);
        $glyphiconPencil = Html::tag('i', null, [
            'class' => 'glyphicon glyphicon-pencil',
            'data-role' => 'rename-document',
        ]);
        $content = $glyphiconRemove . $glyphiconPencil . $img . $p;

        return Html::tag('div', $content, ['class' => 'col-sm-1','data-id' => $model->id,]);
    }

    public function getModule()
    {
        return Yii::$app->getModule('attachdocument');
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
}