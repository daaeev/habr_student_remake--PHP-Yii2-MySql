<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

if (!empty($models_array)) {
    $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]);

    foreach ($models_array as $index => $model) {
        echo $form->field($model, "image[$index]")->fileInput()->label($model->tag_name);
    }

    echo Html::submitButton('Submit', ['class' => 'btn btn-success tags-form_btn']);
    $form = ActiveForm::end();
} else {
    echo Html::tag('p', 'All tags have been created', [
        'class' => 'h5',
    ]);
}

