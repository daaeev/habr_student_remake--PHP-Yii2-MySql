<?php

use app\components\UrlGenHelper;

?>
<img src="/public/img/error.png" alt="error_img">
<p>Страница не найдена</p>
<a href=<?= UrlGenHelper::home() ?>>На главную страницу</a>