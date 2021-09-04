<?php

use app\components\UrlGenHelper;

?>
<div class="login_form_block">
    <p class="title">Вход</p>

    <form>
        <p>E-mail</p>
        <input type="text">

        <p>Пароль</p>
        <input type="password">

        <button type="submit">Войти</button>
    </form>

    <a href="" class="forgot_password">Забыли пароль?</a>

    <div class="login_with_soc">
        <p>Или войдите с помощью других сервисов</p>

        <a class="soc_links facebook" href=""><i class="bi bi-facebook"></i></a>
        <a class="soc_links gmail" href=""><i class="bi bi-google"></i></a>
    </div>
</div>

<p class="registration_link">Ещё нет аккаунта? <a href=<?= UrlGenHelper::simpleRoute('registration') ?>>Зарегистрируйтесь</a></p>