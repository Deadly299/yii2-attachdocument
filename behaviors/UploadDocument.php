<?php

namespace deadly299\attachdocument\behaviors;

use deadly299\attachdocument\models\AttachDocument;
use deadly299\attachdocument\models\PlaceHolder;
use deadly299\attachdocument\ModuleTrait;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

class UploadDocument extends Behavior
{
    use ModuleTrait;

    public $createAliasMethod = false;
    public $modelClass = null;
    public $uploadsPath = '';
    public $mode = 'multiple';
    public $webUploadsPath = '/docs';
    public $allowExtensions = ['pdf', 'doc', 'xls', 'xl'];
    public $inputName = 'attachDocumentFiles';
    private $doReset = true;
    public $galleryId = false;

    const STATUS_SUCCESS = 0;

    public function init()
    {
        if (empty($this->uploadsPath)) {
            $this->uploadsPath = yii::$app->getModule('attachDocument')->documentsStorePath;
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setDocs',
            ActiveRecord::EVENT_AFTER_INSERT => 'setDocs',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeDocs',
        ];
    }

    public function setDocs($event)
    {

        $userDocs = UploadedFile::getInstancesByName($this->getInputName());
        $storePath = $this->getModule()->getStorePath($this->owner);
        $docSubDir = $this->getModule()->getModelSubDir($this->owner);
        $newAbsolutePath = $storePath . DIRECTORY_SEPARATOR . $docSubDir;

        $a = 1;
        if ($userDocs && $this->doReset) {
            foreach ($userDocs as $file) {
                if (in_array(strtolower($file->extension), $this->allowExtensions)) {

                    if (!file_exists($newAbsolutePath)) {
                        BaseFileHelper::createDirectory($newAbsolutePath, 0775, true);
                    }

                    $pathToSave = "{$newAbsolutePath}/{$file->baseName}.{$file->extension}";
                    $fileName = "{$file->baseName}.{$file->extension}";
                    $filePath = "{$docSubDir}/{$fileName}";
                    $file->saveAs($pathToSave);
                    $this->attachDoc($pathToSave, $fileName, $filePath, $file->extension);
                }
            }

            $this->doReset = false;
        }

        return $this;
    }

    public function attachDoc($absolutePath, $fileName, $filePath, $extension)
    {
        if (!preg_match('#http#', $absolutePath)) {
            if (!file_exists($absolutePath)) {
                throw new \Exception('File not exist! :' . $absolutePath);
            }
        }

        if (!$this->owner->id) {
            throw new \Exception('Owner must have id when you attach docs!');
        }

        if ($this->modelClass === null) {
            $documentModel = new AttachDocument();
        } else {
            $documentModel = new ${$this->modelClass}();
        }

        $documentModel->item_id = $this->owner->id;
        $documentModel->file_name = $fileName;
        $documentModel->file_path = $filePath;
        $documentModel->model = $this->getModule()->getShortClass($this->owner);
        $documentModel->url_alias = $this->getAlias($documentModel);
        $documentModel->extension = $extension;

        if (!$documentModel->save()) {
            return false;
        }

        if (count($documentModel->getErrors()) > 0) {
            $ar = array_shift($documentModel->getErrors());

            unlink($newAbsolutePath);
            throw new \Exception(array_shift($ar));
        }

        return $documentModel;
    }

    public function getDocuments()
    {
        $finder = $this->getDocumentsFinder();

        $documentQuery = AttachDocument::find()->where($finder);
        $documentQuery->orderBy(['id' => SORT_ASC]);
        $documentRecords = $documentQuery->all();
        if (!$documentRecords) {
            return [$this->getModule()->getPlaceHolder()];
        }

        return $documentRecords;
    }

    public function getDocumnet()
    {
        $finder = $this->getDocumentsFinder();
        $docQuery = AttachDocument::find()->where($finder);
        $docQuery->orderBy(['id' => SORT_ASC]);
        $doc = $docQuery->one();

        if (!$doc) {
            return $this->getModule()->getPlaceHolder();
        }

        return $doc;
    }

    public function getDocumentByName($name)
    {
        if ($this->getModule()->className === null) {
            $documnetQuery = AttachDocument::find();
        } else {
            $class = $this->getModule()->className;
            $documnetQuery = $class::find();
        }

        $finder = $this->getImagesFinder(['name' => $name]);
        $documnetQuery->where($finder);
        $documnetQuery->orderBy(['id' => SORT_ASC]);
        $img = $documnetQuery->one();

        if (!$cocumnet) {
            return $this->getModule()->getPlaceHolder();
        }

        return $cocumnet;
    }

    public function removeDocs()
    {
        $documents = $this->owner->getDocuments();

        if (count($documents) < 1) {
            return true;
        } else {
            foreach ($documents as $document) {
                $this->owner->removeDocumnet($document);
            }
        }
    }

    public function removeDocumnet(AttachDocument $document)
    {
        $storePath = $this->getModule()->getStorePath();
        $fileToRemove = $storePath . DIRECTORY_SEPARATOR . $document->file_path;

        if (preg_match('@\.@', $fileToRemove) and is_file($fileToRemove)) {
            unlink($fileToRemove);
//            unlink($storePath. DIRECTORY_SEPARATOR . $document->model);
        }

        $document->delete();
    }

    private function getDocumentsFinder($additionWhere = false)
    {
        $base = [
            'item_id' => $this->owner->id,
            'model' => $this->getModule()->getShortClass($this->owner),
        ];

        if ($additionWhere) {
            $base = \yii\helpers\BaseArrayHelper::merge($base, $additionWhere);
        }

        return $base;
    }

    private function getAliasString()
    {
        if ($this->createAliasMethod) {
            $string = $this->owner->{$this->createAliasMethod}();
            if (!is_string($string)) {
                throw new \Exception("Image's url must be string!");
            } else {
                return $string;
            }

        } else {
            return substr(md5(microtime()), 0, 10);
        }
    }

    private function getAlias()
    {
        $aliasWords = $this->getAliasString();
        $documentCount = count($this->owner->getDocuments());

        return $aliasWords . '-' . intval($documentCount + 1);
    }

    public function getInputName()
    {
        return $this->inputName;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function hasDocument()
    {
        return ($this->getDocumnet() instanceof PlaceHolder) ? false : true;
    }
}
