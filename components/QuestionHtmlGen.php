<?php

namespace app\components;

/*
   Helper class for generating html code for questions
*/
class QuestionHtmlGen
{
    public static function tagLinkGen($question)
    {
        $tag = $question->questionToTagTags[0]->tag;
        $tags_count = count($question->questionToTagTags);

        return '<a href="" class="tag"><img src=' . $tag->getImage() . ' alt="tag">' . $tag->tag_name . '</a><span class="tags_counter">' . ($tags_count == 1 ? null : '+' . $tags_count - 1) . '</span>';
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
