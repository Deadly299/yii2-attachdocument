<?php
namespace deadly299\attachdocument;

use Yii;
use deadly299\attachdocument\models\PlaceHolder;
use deadly299\attachdocument\models\AttachDocument;

class Module extends \yii\base\Module
{
    public $documentsStorePath = '@app/web/store';
    public $placeHolderPath;
    public $adminRoles = ['admin', 'superadmin'];

    public function getStorePath()
    {
        return Yii::getAlias($this->documentsStorePath);
    }

    public function getModelSubDir($model)
    {
        $modelName = $this->getShortClass($model);
        $modelDir = $modelName . '/' . $modelName . $model->id;

        return $modelDir;
    }


    public function getShortClass($obj)
    {
        $className = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $className, $matches)) {
            $className = $matches[1];
        }

        return $className;
    }

    public function init()
    {
        parent::init();

        $app = yii::$app;

        if (!isset($app->i18n->translations['attachDocumnet']) && !isset($app->i18n->translations['attachDocumnet*'])) {
            $app->i18n->translations['attachDocumnet'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__.'/messages',
                'forceTranslation' => true
            ];
        }

        if (!$this->documentsStorePath or $this->documentsStorePath == '@app')
            throw new \Exception('Setup documnetsStorePath documnets module properties!!!');
    }

    public function getPlaceHolder(){

        if($this->placeHolderPath){
            return new PlaceHolder();
        }else{
            return null;
        }
    }
}
