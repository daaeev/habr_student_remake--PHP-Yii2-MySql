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
        $count = count($question->userToQuestionViews);

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

    /* 
       Generation of buttons such as edit, delete, etc.
       $object --> comment or question
    */
    public static function generateQuestionControlButtons($object, $user, $type = 'comment')
    {
        if ($object->isAuthor($user)) {
            $buttons = [
                'edit' => self::generateButton('control-btn edit-btn', '<i class="bi bi-pencil-fill"></i>'),
                'delete' => self::generateButton('control-btn delete-btn', '<i class="bi bi-trash-fill"></i>'),
            ];
        } else {
            $buttons = [
                'complain' => self::generateButton('control-btn complain-btn', '<i class="bi bi-shield-fill-exclamation"></i>'),
            ];
            
            if ($type != 'comment') {
                $buttons = [];
            }
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

    /*
       Обработчик текста. Функция экранирует весь контент, кроме определённых тегов ($tagsLetters)
    */
    public static function contentProcessing(string $str)
    {
        $tagsLetters = ['b', 's', 'q', 'code'];  // перечёркнутый s, жирный b, код code, цитата q

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
