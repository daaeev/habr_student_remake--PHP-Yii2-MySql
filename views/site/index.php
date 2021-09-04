<?php

use app\components\UrlGenHelper;

?>
<content id="index">
    <p class="upper_title_index">Все вопросы</p>

    <div class="category_block">
        <a href=<?= UrlGenHelper::categorySetting('new') ?> class="category_setting new">Новые вопросы</a>
        <a href=<?= UrlGenHelper::categorySetting('interesting') ?> class="category_setting interesting">Интересные</a>
        <a href=<?= UrlGenHelper::categorySetting('noanswer') ?> class="category_setting noanswer">Без ответа</a>
    </div>

    <div class="questions_block">
        <div class="question">
            <div class="info_block">
                <a href="" class="tag"><img src="img/tag.jpg" alt="tag">windows</a><span class="tags_counter">+1</span>
                <span class="сomplexity"><i class="bi bi-speedometer2 easy"></i>Простой</span>

                <p class="title"><a href="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, animi!</a></p>

                <div class="soc_info">
                    <span class="subscribes">4 подписчика</span> |
                    <span class="pub_date">43 минуты назад</span> |
                    <span class="viewed">64 просмотра</span> 
                </div>
            </div>

            <a href="" class="answers"><span>2</span> ответа</a>
        </div>

        <div class="question">
            <div class="info_block">
                <a href="" class="tag"><img src="img/tag.jpg" alt="tag">windows</a><span class="tags_counter">+1</span>
                <span class="сomplexity"><i class="bi bi-speedometer2 easy"></i>Простой</span>

                <p class="title"><a href="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, animi!</a></p>

                <div class="soc_info">
                    <span class="subscribes">4 подписчика</span> |
                    <span class="pub_date">43 минуты назад</span> |
                    <span class="viewed">64 просмотра</span> 
                </div>
            </div>

            <a href="" class="answers"><span>2</span> ответа</a>
        </div>

        <div class="question">
            <div class="info_block">
                <a href="" class="tag"><img src="img/tag.jpg" alt="tag">windows</a><span class="tags_counter">+1</span>
                <span class="сomplexity"><i class="bi bi-speedometer2 easy"></i>Простой</span>

                <p class="title"><a href="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum, animi!</a></p>

                <div class="soc_info">
                    <span class="subscribes">4 подписчика</span> |
                    <span class="pub_date">43 минуты назад</span> |
                    <span class="viewed">64 просмотра</span> 
                </div>
            </div>

            <a href="" class="answers"><span>2</span> ответа</a>
        </div>
    </div>
</content>