<?php

use app\components\UrlGenHelper;

?>
<div class="registration_block">
    <p class="title">Регистрация</p>

    <div class="register_with_soc">
        <p>C помощью сервиса</p>

        <a class="soc_links facebook" href=""><i class="bi bi-facebook"></i></a>
        <a class="soc_links gmail" href=""><i class="bi bi-google"></i></a>
    </div>

    <form>
        <p>E-mail</p>
        <input type="text">

        <p>Никнейм</p>
        <input type="text">

        <p>Пароль</p>
        <input type="password">

        <p>Подтвердите пароль</p>
        <input type="password">

        <button type="submit">Зарегистрироваться</button>
    </form>
</div>

<p class="authorization_link">Уже зарегистрированы? <a href=<?= UrlGenHelper::simpleRoute('login') ?>>Войдите</a></p>