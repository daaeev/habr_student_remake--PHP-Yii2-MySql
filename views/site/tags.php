<?php 

use app\components\UrlGenHelper;
use yii\widgets\LinkPager;
use app\components\tags\TagsHtmlGen;

?>
<content id="tags">
    <p class="upper_title_tags"><?= Yii::t('main', 'Все теги') ?></p>

    <div class="tags_block">
        <?php foreach ($tags as $tag): ?>
            <div class="tag">
                <a href=<?= UrlGenHelper::tag($tag->id) ?>><img src=<?= $tag->getImage() ?> alt="tag"></a>

                <p class="info"><a href=<?= UrlGenHelper::tag($tag->id) ?>><?= $tag->tag_name ?></a></p>
                <p class="info questions_count"><a href=<?= UrlGenHelper::tag($tag->id) ?>><?= TagsHtmlGen::questionsCount($tag) ?></a></p>
                <?= TagsHtmlGen::subscribeButton($tag) ?>
            </div>
        <?php endforeach ?>
    </div>

    <?=
        LinkPager::widget([
            'pagination' => $pagination,
        ]); 
    ?>
</content>