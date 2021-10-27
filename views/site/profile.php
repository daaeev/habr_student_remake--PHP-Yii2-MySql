<?php

use app\components\UrlGenHelper;

?>
<content id='profile'>
    <div class="profile_stats">
        <img src=<?= $user->getImage() ?> alt="user image" class="user_img">
        <p class="username"><?= $user->name ?></p>

        <div class="user_stats_info">
            <a href="" class="questions"><span>4</span> вопроса</a>
            <a href="" class="answers"><span>4</span> ответа</a>
        </div>

        <div class="more_info_link_block">
            <a href=<?= UrlGenHelper::user($user->id, 'about') ?> class="info_link about-btn">Информация</a>
            <a href=<?= UrlGenHelper::user($user->id, 'questions') ?> class="info_link questions-btn">Вопросы</a>
            <a href=<?= UrlGenHelper::user($user->id, 'answers') ?> class="info_link answers-btn">Ответы</a>
        </div>

        <div class="chapter_block">
            <?= $this->renderFile("@app/views/partials/profile/$chapter.php", compact('user')) ?>
        </div>
    </div>
</content>