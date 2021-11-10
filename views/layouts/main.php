<?php 

use app\components\UrlGenHelper;
use yii\helpers\Html;
use app\components\questions\QuestionHtmlGen;

$this->beginPage(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        $this->registerMetaTag(['charset' => 'utf-8']);
        $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
        $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        echo Html::csrfMetaTags();
        app\assets\FloatingPanelAsset::register($this);
        $this->head();
    ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if ($this->beginCache('header', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): ?>
    <header>
        <div class="header_block">
            <div class="header_left_block">
                <button class="menu menu-btn"><i class="bi bi-list"></i></button>
                <a href=<?= UrlGenHelper::home() ?> class="logo">Хабр<span>Q&A</span></a>
            </div>
            <a href=<?= UrlGenHelper::simpleRoute('ask') ?> class="ask_question"><?= Yii::t('main', 'Задать вопрос') ?></a>
        </div>
    </header>
<?php $this->endCache(); endif ?>

    <div id="content_container">
        <aside id="left">
                <div class="nav_links">
                    <?php if (Yii::$app->user->isGuest): ?>

                        <a href=<?= UrlGenHelper::login() ?> class="l_sidebar_link login_link"><i class="bi bi-lock"></i><span><?= Yii::t('main', 'Войти на сайт') ?></span></a>

                    <?php else: ?>

                        <div class="profile_link_block">
                            <a href=<?= UrlGenHelper::user($this->params['user']->id) ?> class="l_sidebar_link profile_link"><img src=<?= $this->params['user']->getImage() ?> alt="author" class="author_img"><span><?= Html::encode($this->params['user']->name) ?></span></a>
                            <a href=<?= UrlGenHelper::simpleRoute('change') ?> class="l_sidebar_link first_link"><i class="bi bi-lock"></i></a>
                            <a href=<?= UrlGenHelper::logout() ?> class="l_sidebar_link first_link"><i class="bi bi-box-arrow-right"></i></a>
                        </div>
                        <a href=<?= UrlGenHelper::simpleRoute('my/interesting') ?> class="l_sidebar_link"><i class="bi bi-card-list"></i><span><?= Yii::t('main', 'Моя лента') ?></span></a>

                    <?php endif ?>

                        <a href=<?= UrlGenHelper::simpleRoute('questions/noanswer') ?> class="l_sidebar_link"><i class="bi bi-question-square"></i><span><?= Yii::t('main', 'Все вопросы') ?></span></a>
                        <a href=<?= UrlGenHelper::simpleRoute('tags') ?> class="l_sidebar_link"><i class="bi bi-tag"></i><span><?= Yii::t('main', 'Все теги') ?></span></a>

                    <?php if (Yii::$app->user->can('adminPanel')): ?>   
                         
                        <a href=<?= UrlGenHelper::adminPanel() ?> class="l_sidebar_link"><i class="bi bi-sliders"></i><span><?= Yii::t('main', 'Админ панель') ?></span></a>

                    <?php endif ?>  
                </div>
                <?php if ($this->beginCache('footer_left', [
                            'variations' => [Yii::$app->language],
                            'duration' => 3600 * 24
                        ])): 
                ?>
                    <div class="footer_block">
                        <p class="title"><?= Yii::t('main', 'Что-нибудь') ?>...</p>
                        <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum cupiditate corrupti consectetur, temporibus nulla optio.</p>
                    </div>
                <?php $this->endCache(); endif ?>
        </aside>

            <?= $content ?>

        <aside id="right">
            <p class="title"><?= Yii::t('main', 'Самое интересное за 24 часа') ?></p>

            <?php foreach ($this->params['sidebar_questions'] as $question): ?>
                <div class="question">
                    <p class="title"><a href=<?= UrlGenHelper::question($question->id) ?>><?= $question->title ?></a></p>
                    <div class="soc_info">
                        <span class="subscribes"><?= QuestionHtmlGen::subscribes($question) ?></span> |
                        <span class="answers"><?= QuestionHtmlGen::answersCount($question, false) ?></span> 
                    </div>
                </div>
            <?php endforeach ?>
        </aside>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>