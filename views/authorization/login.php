<?php

use app\components\UrlGenHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="login_form_block">
<?php if ($this->beginCache('login_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
    <p class="title"><?= Yii::t('main', 'Вход') ?></p>

    <?php $form = ActiveForm::begin() ?>

    <div class="field">
        <?= $form->field($model, 'email') ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>

    <?= Html::submitButton(Yii::t('main', 'Войти')) ?>

    <?php $form = ActiveForm::end() ?>

    <a href=<?= UrlGenHelper::forgotPass() ?> class="forgot_password"><?= Yii::t('main', 'Забыли пароль?') ?></a>

    <div class="login_with_soc">
        <p><?= Yii::t('main', 'Или войдите с помощью других сервисов') ?></p>

        <a class="soc_links facebook" href=""><i class="bi bi-facebook"></i></a>
        <a class="soc_links gmail" href=""><i class="bi bi-google"></i></a>
    </div>
</div>

<p class="registration_link"><?= Yii::t('main', 'Ещё нет аккаунта?') ?> <a href=<?= UrlGenHelper::registration() ?>><?= Yii::t('main', 'Зарегистрируйтесь') ?></a></p>
<?php $this->endCache(); endif ?>