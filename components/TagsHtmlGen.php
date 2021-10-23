<?php

namespace app\components;

use app\components\TagsHelper;

/*
   Helper class for generating html code for tags
*/
class TagsHtmlGen
{
    public static function questionsCount($tag)
    {
        $count = count($tag->questionToTagTags);

        return $count . ' ' . TagsHelper::numToWord($count, ['вопрос', 'вопроса', 'вопросов']);
    }

    public static function subsCount($tag)
    {
        return 'Подписаться ' . '<span>' . count($tag->userToTagSubs) . '</span>';
    }
}