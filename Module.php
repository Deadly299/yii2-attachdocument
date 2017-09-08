<?php

namespace deadly299\attachdocument;

/**
 * document-upload module definition class
 */
class Module extends \yii\base\Module
{
    public $documentsStorePath = '@app/web/documents/store';
    public $pictureDocumentPath = '@app/web/images';

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
