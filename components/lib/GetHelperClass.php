<?php

namespace app\components\lib;

use yii\data\Pagination;

class GetHelperClass 
{
    /*
       Algorithm for creating pagination described in the documentation
    */
    protected static function getPaginationData($query)
    {
        $countQuery = $query->count();
        $pagination = new Pagination(['totalCount' => $countQuery, 'pageSize' => 20]);
        
        $questions = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return compact('pagination', 'questions');
    }
}