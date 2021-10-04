<?php

namespace app\components;

use app\components\UrlGenHelper;
use app\components\QuestionHelper;
use app\models\UserToCommentLike;
use app\models\UserToQuestionSub;
use yii\helpers\Html;

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
            if ($comment->comment_kind == 2) {
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

    public static function commentsButton($comments, $class)
    {
        $count = count($comments);
        if ($count > 0) 
            $title = '<span>' . $count . '</span>' . ' ' . QuestionHelper::numToWord($count, ['комментарий', 'комментария', 'комментариев']);
        else
            $title = 'Комментировать';

        return self::generateButton($class, $title);
    }
    
    public static function subscribesButton($question)
    {
        $count = count($question->userToQuestionSubs);
        $class = 'subscribe-btn ' . $question->id;
        $title = '';

        if ($count > 0) 
            $title =  'Подписаться ' . '<span>' . $count . '</span>';
        else
            $title = 'Подписаться';

        if (QuestionHelper::existCheck(UserToQuestionSub::class, ['question_id' => $question->id])) 
            $class .= ' cl';
    
        return self::generateButton($class, $title);
    }

    public static function likesButton($comment)
    {
        $count = count($comment->userToCommentLikes);
        $class = 'like-btn';
        $title = '';

        if ($count > 0) 
            $title = 'Нравится ' . '<span>' . $count . '</span>';
        else
            $title = 'Нравится';

        if (QuestionHelper::existCheck(UserToCommentLike::class, ['comment_id' => $comment->id])) 
            $class .= ' cl';
        
        return self::generateButton($class, $title);
    }

    public static function generateQuestionControlButtons($comment, $user)
    {
        if ($comment->isAuthor($user)) {
            $buttons = [
                'edit' => self::generateButton('control-btn edit-btn', '<i class="bi bi-pencil-fill"></i>'),
                'delete' => self::generateButton('control-btn delete-btn', '<i class="bi bi-trash-fill"></i>'),
            ];
        } else {
            $buttons = [
                'complain' => self::generateButton('control-btn complain-btn', '<i class="bi bi-shield-fill-exclamation"></i>'),
            ];
        }

        foreach ($buttons as $button) {
            echo $button;
        }
    }

    public static function generateFormHelpButtons()
    {
        $buttons = [
            'some1' => self::generateButton('', 'B'),
            'some2' => self::generateButton('', 'B'),
            'some3' => self::generateButton('', 'B'),
        ];


        foreach ($buttons as $button) {
            echo $button;
        }
    }

    private static function generateButton($class, $title)
    {
        return '<button type="button" class="' . $class . '">' . $title . '</button>';
    }

    public static function contentProcessing($text)
    {
        // TODO...

        $content = $text;
        return Html::encode($content);
    }
}
