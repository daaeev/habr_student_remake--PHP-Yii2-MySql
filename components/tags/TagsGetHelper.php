<?php

namespace app\components\tags;

use app\models\Tags;
use app\components\lib\GetHelperClass;

/*
   Class for getting the tags
*/
class TagsGetHelper extends GetHelperClass
{
    public static function allTags()
    {
        $tags_query = Tags::find()
        ->cache(100)
        ->with('questionToTagTags', 'userToTagSubs')
        ->orderBy('id DESC');

    $data = self::getPaginationData($tags_query);
    
    return $data;
    }
}