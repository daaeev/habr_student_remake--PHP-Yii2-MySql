<?php

use app\components\UrlGenHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="login_form_block">
    <p class="title">Вход</p>

    <?php $form = ActiveForm::begin() ?>

    <div class="field">
        <?= $form->field($model, 'email') ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>

    <?= Html::submitButton('Войти') ?>

    <?php $form = ActiveForm::end() ?>

    <a href="" class="forgot_password">Забыли пароль?</a>

    <div class="login_with_soc">
        <p>Или войдите с помощью других сервисов</p>

        <a class="soc_links facebook" href=""><i class="bi bi-facebook"></i></a>
        <a class="soc_links gmail" href=""><i class="bi bi-google"></i></a>
    </div>
</div>

<p class="registration_link">Ещё нет аккаунта? <a href=<?= UrlGenHelper::registration() ?>>Зарегистрируйтесь</a></p>