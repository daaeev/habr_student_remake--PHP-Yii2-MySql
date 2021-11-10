<?php

namespace app\components\questions;

use app\components\UrlGenHelper;
use app\components\questions\QuestionHelper;
use app\models\UserToCommentLike;
use app\models\UserToQuestionSub;
use app\components\lib\HtmlGenHelper;
use Yii;

/*
   Helper class for generating html code for questions
*/
class QuestionHtmlGen extends HtmlGenHelper
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
        
        return $count . ' ' . Yii::t('main', QuestionHelper::numToWord($count, ['подписчик', 'подписчика', 'подписчиков']));
    }

    public static function views($question)
    {
        $count = count($question->userToQuestionViews);

        return $count . ' ' .Yii::t('main',  QuestionHelper::numToWord($count, ['просмотр', 'просмотра', 'просмотров']));
    }

    public static function answersCount($question, $link = true)
    {
        $count = 0;
        $isAnswered = false;
        $class = 'answers';

        foreach ($question->comments as $comment) {
            if ($comment->comment_kind == 2 || $comment->comment_kind == 4) 
                $count++;
            
            if ($isAnswered == false && $comment->comment_kind == 4)
                $isAnswered = true;
        }

        $class .= ($isAnswered ? ' is-answered' : '');
        
        if ($link)
            return '<a href=' . UrlGenHelper::question($question->id) . ' class="' . $class . '"><span>' . $count . '</span> ' . Yii::t('main', QuestionHelper::numToWord($count, ['ответ', 'ответа', 'ответов'])) . '</a>';
        
        return $count . ' ' . Yii::t('main', QuestionHelper::numToWord($count, ['ответ', 'ответа', 'ответов']));
    }

    public static function difficulty($difficulty)
    {
        switch ($difficulty) {
            case 'Простой':
                return '<i class="bi bi-speedometer2 easy"></i>' . Yii::t('main', $difficulty);
            case 'Средний':
                return '<i class="bi bi-speedometer2 medium"></i>' . Yii::t('main', $difficulty);
            case 'Сложный':
                return '<i class="bi bi-speedometer2 hard"></i>' . Yii::t('main', $difficulty);
        }
    }

    public static function commentsButton($comments, $class)
    {
        $count = count($comments);
        if ($count > 0) 
            $title = '<span>' . $count . '</span>' . ' ' . Yii::t('main', QuestionHelper::numToWord($count, ['комментарий', 'комментария', 'комментариев']));
        else
            $title = Yii::t('main', 'Комментировать');

        return self::generateButton($class, $title);
    }
    
    public static function subscribesButton($question)
    {
        $count = count($question->userToQuestionSubs);
        $class = 'subscribe-btn ' . $question->id . ' subscribe_ques-btn';
        $sub_title = Yii::t('main', 'Подписаться');
        $title = '';

        if ($count > 0) 
            $title =  $sub_title . ' ' . '<span>' . $count . '</span>';
        else
            $title = $sub_title;

        if (QuestionHelper::existCheck(UserToQuestionSub::class, ['question_id' => $question->id])) 
            $class .= ' cl';
    
        return self::generateButton($class, $title);
    }

    public static function likesButton($comment)
    {
        $count = count($comment->userToCommentLikes);
        $class = 'like-btn';
        $like_title = Yii::t('main', 'Нравится');
        $title = '';

        if ($count > 0) 
            $title = $like_title . ' ' . '<span>' . $count . '</span>';
        else
            $title = $like_title;

        if (QuestionHelper::existCheck(UserToCommentLike::class, ['comment_id' => $comment->id])) 
            $class .= ' cl';
        
        return self::generateButton($class, $title);
    }

    /* 
       Generation of buttons such as edit, delete, etc.
       $object --> comment or question
    */
    public static function generateControlButtons($object, $user, $type = 'comment')
    {
        $buttons = [];

        if (@Yii::$app->view->params['user']->status != 3) {
            if ($object->isAuthor($user)) {
                $buttons = [
                    'edit' => self::generateButton('control-btn edit-btn', '<i class="bi bi-pencil-fill"></i>'),
                    'delete' => self::generateButton('control-btn delete-btn', '<i class="bi bi-trash-fill"></i>'),
                ];

                if ($type == 'question') 
                    unset($buttons['edit']);
            } else {
                $buttons = [
                    'complain' => self::generateButton('control-btn complain-btn', '<i class="bi bi-shield-fill-exclamation"></i>'),
                ];
                
                if ($type == 'comment' && $object->comment_kind == 2) {
                    if ($object->question->author_id == @Yii::$app->view->params['user']->id) 
                        $buttons['approve'] = self::generateButton('control-btn approve_ques-btn', '<i class="bi bi-check"></i>');
                }

                if ($type == 'question') 
                    unset($buttons['complain']);
            }
        }

        foreach ($buttons as $button) {
            echo $button;
        }
    }

    public static function generateFormHelpButtons()
    {
        $buttons = [
            'bold' => self::generateButton('form_bold-btn', 'B'),
            'italic' => self::generateButton('form_italic-btn', 'B'),
            'underline' => self::generateButton('form_underline-btn', 'B'),
            'crossed' => self::generateButton('form_crossed-btn', 'B'),
            'code' => self::generateButton('form_code-btn', htmlspecialchars('</>')),
        ];


        foreach ($buttons as $button) {
            echo $button;
        }
    }

    /*
       Обработчик текста. Функция экранирует весь контент, кроме определённых тегов ($tagsLetters)
    */
    public static function contentProcessing(string $str)
    {
        $tagsLetters = ['b', 'i', 'u', 's', 'code'];

        $result = '';
        $openAndCloseTags = []; // openTag => closeTag
        
        // Получил открывающий и закрывающий теги
        foreach ($tagsLetters as $tag) {
            $openTag = '<' . $tag . '>';
            $closeTag = '</' . $tag . '>';
        
            $openAndCloseTags[$openTag] = $closeTag;
        }
        
        // Заменил закрывающие теги на сгенерированным разделитель типа: '-?#14#&-'
        $replacedCloseTagsString = $str;
        $replaceString = '-?#' . rand(10, 20) . '#&-';
        
        foreach ($openAndCloseTags as $openTag => $closeTag) {
            $replacedCloseTagsString = str_replace($closeTag, $replaceString, $replacedCloseTagsString);
        }
        
        // Разбил главную строку по сгенерированным разделителям ($replacedCloseTagsString)
        $exploadedByReplacedCloseTag = explode($replaceString, $replacedCloseTagsString);
        
        // Получил общее количество тегов в строке, которое нужно экранировать (нужно при результирующей обработке)
        $countOfNotEncodeTags = 0;
        foreach ($exploadedByReplacedCloseTag as $string) {
            foreach($openAndCloseTags as $openTag => $closeTag) {
                if (is_numeric(strpos($string, $openTag))) {
                    $countOfNotEncodeTags++;
                }
            }
        }

        // Если нет тегов, которые НЕ нужно экранировать, то возвращаем экранированный основной контент
        if ($countOfNotEncodeTags == 0) {
            return htmlspecialchars($str);
        }
        
        // Обработал $exploadedByReplacedCloseTag, получив результирующую строку
        $iter = 0;
        foreach ($exploadedByReplacedCloseTag as $string) {
            foreach ($openAndCloseTags as $openTag => $closeTag) {
        
                // Если есть указанный тег в строке, то разбиваем её по нему и соединяем, экранирую нужный контент
                if (is_numeric(strpos($string, $openTag))) {
                    $explodeContent = explode($openTag, $string);
                    $result .= htmlspecialchars($explodeContent[0]) . $openTag . htmlspecialchars($explodeContent[1]) . $closeTag;
                }
                
                // Если тегов больше не осталось и остался контент, то добавляем его в результирующею строку
                if ($iter == ($countOfNotEncodeTags - 1)) {
                    $result .= htmlspecialchars($exploadedByReplacedCloseTag[$iter + 1]);
                    break 2;
                }
            }
        
            $iter++;
        }
        
        return $result;
    }
}
