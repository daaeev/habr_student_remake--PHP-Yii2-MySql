<?php 

use app\components\UrlGenHelper;
use yii\widgets\LinkPager;
use app\components\TagsHtmlGen;

?>
<content id="tags">
    <p class="upper_title_tags">Все теги</p>

    <div class="tags_block">
        <?php foreach ($tags as $tag): ?>
            <div class="tag">
                <a href=<?= UrlGenHelper::tag($tag->id) ?>><img src=<?= $tag->getImage() ?> alt="tag"></a>

                <p class="info"><a href=<?= UrlGenHelper::tag($tag->id) ?>><?= $tag->tag_name ?></a></p>
                <p class="info questions_count"><a href=<?= UrlGenHelper::tag($tag->id) ?>><?= TagsHtmlGen::questionsCount($tag) ?></a></p>
                <button class="subscribe-btn"><?= TagsHtmlGen::subsCount($tag) ?></button>
            </div>
        <?php endforeach ?>
    </div>

    <?=
        LinkPager::widget([
            'pagination' => $pagination,
        ]); 
    ?>
</content>