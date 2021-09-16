<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin() ?>

<?= Html::dropDownList('role', 'user', $roles, ['class' => 'form-control']) ?>

<?= Html::hiddenInput('user_id', $id) ?>

<?= Html::submitButton('Set', [
    'class' => 'btn btn-success btn-set_role',
    'data' => [
            'confirm' => 'Are you sure?',
    ],
]) 
?>

<?php $form = ActiveForm::end() ?>