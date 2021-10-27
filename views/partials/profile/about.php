<?php

use app\components\user\UserHtmlGen;

?>
<p class="user-description"><?= UserHtmlGen::description($user->description) ?></p>