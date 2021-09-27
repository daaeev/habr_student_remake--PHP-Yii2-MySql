<?php

namespace app\components;

use app\components\UrlGenHelper;
use app\components\QuestionHelper;
use app\models\UserToCommentLike;
use app\models\UserToQuestionSub;

/*
   Helper class for generating html code for questions
*/
class QuestionHtmlGen
{
    public static function tagLinkGen($question)
    {
        $tag = $question->questionToTagTags[0]->tag;
        $tags_count = count($question->questionToTagTags);

        return '<a href=' . UrlGenHelper::tag($tag->id) . ' class="tag"><img src=' . $tag->getImage() . ' alt="tag">' . $tag->tag_name . '</a><span class="tags_counter">' . ($tags_count == 1 ? null : '+' . $tags_count - 1) . '</span>';
    }

    public static function allTags($tags)
    {
        $firstTag = $tags[0]->tag;
        $html = '<a class="tag" href=' . UrlGenHelper::tag($firstTag->id) . '><img src=' . $firstTag->getImage() . ' alt="tag">' . $firstTag->tag_name . '</a>';

        for ($i = 1; $i < count($tags); $i++) {
            $tag = $tags[$i]->tag;

            $html .= '<a class="tag" href=' . UrlGenHelper::tag($tag->id) . '><img src=' . $tag->getImage() . ' alt="tag">' . $tag->tag_name . '</a>';
        }

        return $html;
    }

    public static function subscribes($question)
    {
        $count = count($question->userToQuestionSubs);
        
        return $count . ' ' . QuestionHelper::numToWord($count, ['подписчик', 'подписчика', 'подписчиков']);
    }

    public static function views($question)
    {
        $count = $question->viewed;

        return $count . ' ' . QuestionHelper::numToWord($count, ['просмотр', 'просмотра', 'просмотров']);
    }

    public static function answers($question)
    {
        $count = 0;
        foreach ($question->comments as $comment) {
            if ($comment->comment_kind == 1) {
                $count++;
            }
        }

        return '<span>' . $count . '</span> ' . QuestionHelper::numToWord($count, ['ответ', 'ответа', 'ответов']);
    }

    public static function difficulty($difficulty)
    {
        switch ($difficulty) {
            case 'Простой':
                return '<i class="bi bi-speedometer2 easy"></i>' . $difficulty;
            case 'Средний':
                return '<i class="bi bi-speedometer2 medium"></i>' . $difficulty;
            case 'Сложный':
                return '<i class="bi bi-speedometer2 hard"></i>' . $difficulty;
        }
    }

    public static function commentsButton($comments)
    {
        $count = count($comments);
        if ($count > 0) 
            return '<span>' . $count . '</span>' . ' ' . QuestionHelper::numToWord($count, ['комментарий', 'комментария', 'комментариев']);
        
        return 'Комментировать';
    }
    
    public static function subscribesButton($question)
    {
        $count = count($question->userToQuestionSubs);
        $class = 'subscribe-btn ' . $question->id;
        $content = '';

        if ($count > 0) 
            $content =  'Подписаться ' . '<span>' . $count . '</span>';
        else
            $content = 'Подписаться';

        if (QuestionHelper::existCheck(UserToQuestionSub::class, ['question_id' => $question->id])) 
            $class .= ' cl';
    
        return self::generateButton($class, $content);
    }

    public static function likesButton($comment)
    {
        $count = count($comment->userToCommentLikes);
        $class = 'like-btn ' . $comment->id;
        $content = '';

        if ($count > 0) 
            $content = 'Нравится ' . '<span>' . $count . '</span>';
        else
            $content = 'Нравится';

        if (QuestionHelper::existCheck(UserToCommentLike::class, ['comments_id' => $comment->id])) 
            $class .= ' cl';
        
        return self::generateButton($class, $content);
    }

    private static function generateButton($class, $content)
    {
        return '<button type="button" class="' . $class . '">' . $content . '</button>';
    }
}
