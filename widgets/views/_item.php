<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;

?>
<div class="col-sm-1 products-docs">
    <a class="doc-delete" href="#" data-model-id="<?= $document->id ?>">✖</a>
    <a class="edit" data-toggle="modal" href="#myModal<?= $document->id ?>">

        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </a>
    <?php Modal::begin([
        'header' => 'Редактировать',
        'toggleButton' => [
            'label' => '<a class="edit" data-toggle="modal" href="#myModal' . $document->id . '">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>',
        ],
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>' . Html::submitButton("Сохранить изменения", ["class" => "btn btn-primary"]),
    ]); ?>

    <?php $form = ActiveForm::begin(['action' => 'update-doc']) ?>
    <div class="modal-body">
        <?= $form->field($document, 'name')->textInput(); ?>
        <?= $form->field($document, 'id')->hiddenInput(['value' => $document->id])->label(false); ?>
    </div>
    <?php ActiveForm::end() ?>

    <?php Modal::end(); ?>
    <img src="/frontend/web/images/doc.png" class="img-doc">
    <p class="doc-name">
        <span title="<?= $document->name ?>"><?= $document->name ?></span>
    </p>
</div>
