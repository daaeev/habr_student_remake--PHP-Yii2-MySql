<?php

namespace app\components\tags;

use app\components\tags\TagsHelper;
use app\components\lib\HtmlGenHelper;
use app\models\UserToTagSub;
use Yii;

/*
   Helper class for generating html code for tags
*/
class TagsHtmlGen extends HtmlGenHelper
{
    public static function questionsCount($tag)
    {
        $count = count($tag->questionToTagTags);

        return $count . ' ' . Yii::t('main', TagsHelper::numToWord($count, ['вопрос', 'вопроса', 'вопросов']));
    }

    public static function subscribeButton($tag)
    {
        $count = count($tag->userToTagSubs);
        $class = 'subscribe-btn ' . $tag->id . ' subscribe_tag-btn';
        $sub_title = Yii::t('main', 'Подписаться');
        $title = '';

        if ($count > 0) 
            $title =  $sub_title . ' ' . '<span>' . $count . '</span>';
        else
            $title = $sub_title;

        if (TagsHelper::existCheck(UserToTagSub::class, ['tag_id' => $tag->id])) 
            $class .= ' cl';
    
        return self::generateButton($class, $title);
    }
}