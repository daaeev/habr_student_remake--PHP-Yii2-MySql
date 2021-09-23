<?php

namespace app\components;

use app\components\UrlGenHelper;
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
        
        return $count . ' ' . self::numToWord($count, ['подписчик', 'подписчика', 'подписчиков']);
    }

    public static function views($question)
    {
        $count = $question->viewed;

        return $count . ' ' . self::numToWord($count, ['просмотр', 'просмотра', 'просмотров']);
    }

    public static function answers($question)
    {
        $count = 0;
        foreach ($question->comments as $comment) {
            if ($comment->comment_kind == 1) {
                $count++;
            }
        }

        return '<span>' . $count . '</span> ' . self::numToWord($count, ['ответ', 'ответа', 'ответов']);
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
            return '<span>' . $count . '</span>' . ' ' . self::numToWord($count, ['комментарий', 'комментария', 'комментариев']);
        
        return 'Комментировать';
    }
    
    public static function subscribesButton($question)
    {
        $count = count($question->userToQuestionSubs);
        if ($count > 0) 
            return 'Подписаться ' . '<span>' . $count . '</span>';
        
        return 'Подписаться';
    }

    public static function likesButton($comment)
    {
        $count = count($comment->userToCommentLikes);
        if ($count > 0) 
            return 'Нравится ' . '<span>' . $count . '</span>';
        
        return 'Нравится';
    }

    /*
       Modifies a word based on a number
    */
    private static function numToWord($num, $words)
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        switch ($num) {
            case 1: 
                return($words[0]);
            
            case 2: case 3: case 4: 
                return($words[1]);
            
            default: 
                return($words[2]);
        }
    }
}
