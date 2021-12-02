<?php

use app\components\user\UserHtmlGen;

?>
<?php if ($user->description): ?>
    <div class="description_block">
        <p class="user-description"><?= UserHtmlGen::description($user->description) ?></p>
        <?= $user->id == Yii::$app->view->params['user']->id ? '<button type="button" class="edit_description_btn">' . Yii::t('main', 'Изменить') . '</button>' : '' ?>
    </div>
<?php else: ?>
    <div class="empty_block">
        <p class="empty"><?= Yii::t('main', 'Пользователь ещё не оставил описание!') ?></p>
        <?= $user->id == Yii::$app->view->params['user']->id ? '<button type="button" class="edit_description_btn">' . Yii::t('main', 'Изменить') . '</button>' : '' ?>
    </div>
<?php endif ?>

<?php if ($user->id == Yii::$app->view->params['user']->id): ?>
    <form id="set_user_description_form">
        <input type="text" placeholder = <?= Yii::t('main', 'Введите описание') ?> autocomplete = "off" class="description">
        <input type="hidden" value=<?= $user->id ?> class="author"><br>
        <button type="submit" class="description-form_btn"><?= Yii::t('main', 'Изменить') ?></button>
    </form>
<?php endif ?>