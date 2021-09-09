<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        $this->registerMetaTag(['charset' => 'utf-8']);
        $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
        $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        $this->registerCsrfMetaTags();
        app\assets\WithoutPanelAsset::register($this);

        $this->head();
    ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div id="content_container">
        <?= $content ?>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>