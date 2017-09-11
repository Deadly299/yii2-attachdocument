<?php
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if (!empty($documents)) { ?>
    <?php foreach ($documents as $document) { ?>
        <div class="col-sm-1 deadly299-docs">

            <i class="glyphicon glyphicon-remove" data-role="remove-file-document" data-action="<?= Url::to(['/attachdocument/default/remove-file']) ?>" data-id="<?= $document->id ?>"></i>

            <?php Modal::begin([
                'header' => 'Редактировать',
                'toggleButton' => [
                    'label' => '<a class="edit" data-toggle="modal" href="#myModal' . $document->id . '">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>',
                ],
                'footer' => '<button type="button" class="btn btn-default" data-role="close-modal-upload" data-dismiss="modal">Закрыть</button>
                     <button type="button" data-role="rename-file-document" class="btn btn-primary upload-document">Загрузить</button>',
            ]); ?>
            <div class="modal-body">
                <div class="load-target">
                    <div class="row ">

                        <div class="col-md-12">
                            <?= Html::textInput('newName', null, [
                                'class' => 'form-control',
                                'data-role' => 'input-new-name-file-document',
                                'data-id' => $document->id,
                                'data-action' => Url::to(['/attachdocument/default/rename-file']),
                                'placeholder' => 'название файла'
                            ]); ?>
                        </div>
                    </div>


                </div>
                <hr>
            </div>
            <?php Modal::end(); ?>

            <img src="/frontend/web/images/doc.png" class="img-doc">
            <p class="doc-name">
                <span title="<?= $document->url_alias ?>"><?= $document->url_alias ?></span>
            </p>
        </div>
    <?php } ?>
<?php } ?>

<?php Modal::begin([
    'header' => 'Загрузка документа',
    'toggleButton' => [
        'label' => '<a>
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                            </span>
                            Добавить новый
                    </a>',
    ],
    'footer' => '<button type="button" class="btn btn-default" data-role="close-modal-upload" data-dismiss="modal">Закрыть</button>
                     <button type="button" data-role="upload-file" data-action="'. Url::to(['/attachdocument/default/upload']) .'" class="btn btn-primary upload-document">Загрузить</button>',
]); ?>
<div class="modal-body">
    <div class="load-target">
        <div class="row ">

            <div class="col-md-12">
                <label for="">Файл</label>
                <?= FileInput::widget([

                    'name' => 'filedocument',
                    'options' => [
                        'class' => 'upload-doc',
                        'data-role' => 'input-upload-document',
                        'data-model-name' => substr($model::className(), strrpos($model::className(), '\\') + 1),
                        'data-model-id' => $model->id,
                        'accept' => 'application/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showUpload' => false,
                        'showRemove' => false,
                    ],
//                'pluginLoading' => $this->fileInputPluginLoading
                ]); ?>
                <div data-role="response"></div>
            </div>
            <div class="col-md-12">
                <br>
                <p>При необходимости можете переименовать файл</p>
                <?= Html::textInput('fileName', null, [
                    'class' => 'form-control',
                    'data-role' => 'input-name-document',
                    'placeholder' => 'название файла'
                ]); ?>
            </div>
        </div>


    </div>

</div>
<?php Modal::end(); ?>


