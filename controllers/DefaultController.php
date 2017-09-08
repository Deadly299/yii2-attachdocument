<?php
namespace deadly299\attachdocument\controllers;

use yii\web\Controller;
use deadly299\attachdocument\models\Document;

/**
 * Default controller for the `document-upload` module
 */

class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = Document::find()->all();

        return $this->render('index', ['model' => $model]);
    }
}
