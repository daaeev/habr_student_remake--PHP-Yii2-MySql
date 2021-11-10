<?php

use app\components\UrlGenHelper;
use app\components\user\UserHtmlGen;

?>
<content id='profile'>
    <div class="profile_stats">
        <img src=<?= $user->getImage() ?> alt="user image" class="user_img">
        <p class="username"><?= $user->name ?></p>

        <div class="user_stats_info">
            <a href=<?= UrlGenHelper::userQuestions($user->id) ?> class="questions"><?= UserHtmlGen::questionsCount($user) ?></a>
            <a href=<?= UrlGenHelper::userAnswers($user->id) ?> class="answers"><?= UserHtmlGen::answersCount($user) ?></a>
            <a href=<?= UrlGenHelper::userAnswers($user->id) ?> class="answers"><?= UserHtmlGen::contribution($user) ?></a>
        </div>
    <?php if ($this->beginCache('profile_info_links', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
    ?>
        <div class="more_info_link_block">
            <a href=<?= UrlGenHelper::user($user->id, 'about') ?> class="info_link about-btn"><?= Yii::t('main', 'Информация') ?></a>
            <a href=<?= UrlGenHelper::user($user->id, 'questions') ?> class="info_link questions-btn"><?= Yii::t('main', 'Вопросы') ?></a>
            <a href=<?= UrlGenHelper::user($user->id, 'answers') ?> class="info_link answers-btn"><?= Yii::t('main', 'Ответы') ?></a>
        </div>
    <?php $this->endCache(); endif ?>

        <div class="chapter_block">
            <?= $this->renderFile("@app/views/partials/profile/$chapter.php", compact('user')) ?>
        </div>
    </div>
</content>