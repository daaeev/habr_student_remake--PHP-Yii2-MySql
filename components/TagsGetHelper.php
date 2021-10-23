<?php

namespace app\components;

use app\models\Tags;
use yii\data\Pagination;

/*
   Class for getting the tags
*/
class TagsGetHelper
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

    /*
       Algorithm for creating pagination described in the documentation
    */
    private static function getPaginationData($query)
    {
        $countQuery = $query->count();
        $pagination = new Pagination(['totalCount' => $countQuery, 'pageSize' => 20]);
        
        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return compact('pagination', 'tags');
    }
}