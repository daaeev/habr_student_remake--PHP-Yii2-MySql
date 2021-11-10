<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php 
    $form = ActiveForm::begin([
        'action' => Url::to('ban'),
    ]) 
?>

<?= Html::textarea('ban_reason', '', ['class' => 'form-control', 'placeholder' => 'Reason']) ?>

<?= Html::hiddenInput('question_id', $id) ?>

<?= Html::submitButton('Set', [
    'class' => 'btn btn-success btn-set_role',
    'data' => [
            'confirm' => 'Are you sure?',
    ],
]) 
?>

<?php $form = ActiveForm::end() ?>