<?php


$this->beginPage();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        $this->registerMetaTag(['charset' => 'utf-8']);
        $this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']);
        $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        app\assets\WithoutPanelAsset::register($this);
        $this->head();
    ?>
</head>
<body id="error">
<?php $this->beginBody() ?>
    <div class="error_block">
            <?= $content ?>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>