<?php 

use app\components\UrlGenHelper;

$this->beginPage(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        $this->registerMetaTag(['charset' => 'utf-8']);
        $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
        $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        app\assets\PublicAsset::register($this);

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
                    <a href=<?= UrlGenHelper::simpleRoute('login') ?> class="r_sidebar_link login_link"><i class="bi bi-lock"></i><span>Войти на сайт</span></a>
                    <a href=<?= UrlGenHelper::simpleRoute('my/') ?> class="r_sidebar_link"><i class="bi bi-card-list"></i><span>Моя лента</span></a>
                    <a href=<?= UrlGenHelper::simpleRoute('tags') ?> class="r_sidebar_link"><i class="bi bi-tag"></i><span>Все теги</span></a>
                </div>

                <div class="footer_block">
                    <p class="title">Something...</p>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum cupiditate corrupti consectetur, temporibus nulla optio.</p>
                </div>
        </aside>

            <?= $content ?>

        <aside id="right">
            <p class="title">Самое интересное за 24 часа</p>

            <div class="question">
                <p class="title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, vitae?</p>
                <div class="soc_info">
                    <span class="subscribes">4 подписчика</span> |
                    <span class="answers">0 ответов</span> 
                </div>
            </div>
        </aside>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>