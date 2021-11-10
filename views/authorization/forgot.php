<?php

use yii\helpers\Html;

?>
<?php if ($this->beginCache('forgot_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
<div class="forgot_form_block">
    <p class="title"><?= Yii::t('main', 'Забыли пароль?') ?></p>
    <p class="sup-title"><?= Yii::t('main', 'Введите ваш ник и email, на который придёт новый пароль') ?></p>

    <form>
        <div class="field">
            <input type="text" required placeholder="<?= Yii::t('main', 'Имя пользователя...') ?>" class="username">
        </div>
        <div class="field">
            <input type="text" required placeholder="Email..." class="email">
        </div>

        <?= Html::submitButton(Yii::t('main', 'Отправить новый пароль')) ?>
    </form>
</div>
<?php $this->endCache(); endif ?>