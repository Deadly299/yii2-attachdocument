<?php

namespace deadly299\attachdocument;

/**
 * document-upload module definition class
 */
class Module extends \yii\base\Module
{
    public $documentsStorePath = '@webroot/documents/store';
    public $pictureDocumentPath = '@webroot/images';
    public $iconDocumentPath;

    /**
     * @inheritdoc
     */

    public function init()
    {
        parent::init();

        if(!$this->documentsStorePath or !$this->pictureDocumentPath)
            throw new \Exception('Setup documentsStorePath and pictureDocumentPath documents module properties');

    }
}
