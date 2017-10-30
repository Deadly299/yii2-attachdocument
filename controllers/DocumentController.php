<?php
namespace deadly299\attachdocument\controllers;

use Yii;
use yii\web\Controller;
use deadly299\attachdocument\models\AttachDocument;


/**
 * Default controller for the `document-upload` module
 */

class DocumentController extends Controller
{
    public function actionRemoveFile()
    {
        $dataPost = Yii::$app->request->post();

        $model = AttachDocument::findOne($dataPost['id']);
        if(!empty($model)) {

            $storePath = yii::$app->getModule('attachdocument')->documentsStorePath;
            $fileToRemove = $storePath . DIRECTORY_SEPARATOR . $model->file_path;
            print_r($fileToRemove);
            if (preg_match('@\.@', $fileToRemove) and is_file($fileToRemove)) {
                unlink($fileToRemove);
            }
            $model->delete();
            return true;
        }
    }

    public function actionRenameFile()
    {
        $dataPost = Yii::$app->request->post();

        $model = AttachDocument::findOne($dataPost['id']);
        $model->url_alias = $dataPost['name'];
        $model->save();

    }

    public function actionDownload($hash)
    {
        if(!empty($id)) {
            $ranks = AttachDocument::findOne($hash);
            if(!empty($ranks)) {
                $path = yii::$app->getModule('attachdocument')->documentsStorePath;
                if(file_exists($path. '/'. $ranks->file_path)){
                    return \Yii::$app->response->sendFile($path, $ranks->name.'.'. substr(strrchr($ranks->file_name, '.'), 1));
                }else{
                    throw new NotFoundHttpException('Такого файла не существует ');
                }
            }
        }

    }

    public function actionUpload()
    {
        $uploadsPath = yii::$app->getModule('attachdocument')->documentsStorePath;
        $dataPost = Yii::$app->request->post();

        $fullPath = $uploadsPath . '/' . $dataPost['modelName'] . '/' . $dataPost['modelId'];
        if(isset($_FILES)) {
            foreach ($_FILES as $file) {
                $imageType = explode('/', $file['type']);
                $fileFormat = $imageType[1];
                $newName = hash('crc32',time());

                if (!file_exists($fullPath)){
                    mkdir($fullPath, 0777, true);
                }
                $fullPath .= '/' . $newName . '.' . $fileFormat;
                $path = $dataPost['modelName'] . '/' . $dataPost['modelId'] . '/' . $newName . '.' . $fileFormat;

                if ($imageType[0] == 'application') {
                    if (move_uploaded_file($file['tmp_name'],$fullPath)) {
                        if($dataPost['nameDocument'] != '') {
                            $urlAlias = $dataPost['nameDocument'] . '.' . $fileFormat;
                        } else {
                            $urlAlias = $newName.$fileFormat;
                        }
                        $this->attachFile($dataPost['modelName'], $dataPost['modelId'], $path, $newName.$fileFormat, $urlAlias);

                        echo 'success';
                    } else {
                        echo 'error upload';
                    }
                } else {
                    return 'unsuitable format';
                }
            }

        }
    }

    private function attachFile($modelName, $modelId, $fullPath, $newName, $urlAlias)
    {
        $document = new AttachDocument();
        $document->model = $modelName;
        $document->item_id = $modelId;
        $document->file_name = $newName;
        $document->file_path = $fullPath;
        $document->url_alias = $urlAlias;

        $document->save();
    }
}
