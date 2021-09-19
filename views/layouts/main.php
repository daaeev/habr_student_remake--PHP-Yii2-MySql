<?php 

use app\components\UrlGenHelper;
use yii\helpers\Html;
use app\components\QuestionHtmlGen;

$this->beginPage(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        $this->registerMetaTag(['charset' => 'utf-8']);
        $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
        $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        app\assets\FloatingPanelAsset::register($this);
        $this->head();
    ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header>
        <div class="header_block">
            <a href=<?= UrlGenHelper::home() ?> class="logo">Хабр<span>Q&A</span></a>
            <a href=<?= UrlGenHelper::simpleRoute('ask') ?> class="ask_question">Задать вопрос</a>
        </div>
    </header>

    <div id="content_container">
        <aside id="left">
                <div class="nav_links">
                    <?php if (\Yii::$app->user->isGuest): ?>

                        <a href=<?= UrlGenHelper::login() ?> class="l_sidebar_link login_link"><i class="bi bi-lock"></i><span>Войти на сайт</span></a>

                    <?php else: ?>

                        <div class="profile_link_block">
                            <a href=<?= UrlGenHelper::simpleRoute('profile') ?> class="l_sidebar_link profile_link"><img src="/public/img/author.jpg" alt="author" class="author_img"><span><?= Html::encode(\Yii::$app->user->getIdentity()->name) ?></span></a>
                            <a href=<?= UrlGenHelper::logout() ?> class="l_sidebar_link quit"><i class="bi bi-box-arrow-right"></i></a>
                        </div>
                        <a href=<?= UrlGenHelper::simpleRoute('my/') ?> class="l_sidebar_link"><i class="bi bi-card-list"></i><span>Моя лента</span></a>

                    <?php endif ?>

                        <a href=<?= UrlGenHelper::simpleRoute('questions/noanswer') ?> class="l_sidebar_link"><i class="bi bi-question-square"></i><span>Все вопросы</span></a>
                        <a href=<?= UrlGenHelper::simpleRoute('tags') ?> class="l_sidebar_link"><i class="bi bi-tag"></i><span>Все теги</span></a>

                    <?php if (\Yii::$app->user->can('adminPanel')): ?>   
                         
                        <a href=<?= UrlGenHelper::adminPanel() ?> class="l_sidebar_link"><i class="bi bi-sliders"></i><span>Админ панель</span></a>

                    <?php endif ?>  
                </div>

                <div class="footer_block">
                    <p class="title">Something...</p>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum cupiditate corrupti consectetur, temporibus nulla optio.</p>
                </div>
        </aside>

            <?= $content ?>

        <aside id="right">
            <p class="title">Самое интересное за 24 часа</p>

            <?php foreach ($this->params['sidebar_questions'] as $question): ?>
                <div class="question">
                    <p class="title"><a href=<?= UrlGenHelper::question($question->id) ?>><?= $question->title ?></a></p>
                    <div class="soc_info">
                        <span class="subscribes"><?= QuestionHtmlGen::subscribes($question) ?></span> |
                        <span class="answers"><?= QuestionHtmlGen::answers($question) ?></span> 
                    </div>
                </div>
            <?php endforeach ?>
        </aside>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>