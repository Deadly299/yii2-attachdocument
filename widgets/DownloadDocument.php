<?php
namespace deadly299\attachdocument\widgets;

use yii;

class DownloadDocument extends \yii\base\Widget
{
    public $model;

    public function init()
    {
        return true;
    }

    public function run()
    {
        $links = null;
        $documents = $this->model->getDocuments();

        foreach ($documents as $document) {
            $src = $document->extension == 'pdf' ? '/img/adobe.png' : '/img/text-file.png';
            $img = yii\helpers\Html::img($src, ['class' => 'img-benkala']);
            $links .= yii\helpers\Html::a($img, [
                '/attachDocument/document/download',
                'hash' => $document->url_alias
            ], ['title' => $document->file_name, 'target' => '_blank']);
        }

        return $links;
    }
}