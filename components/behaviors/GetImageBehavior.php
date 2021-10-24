<?php

namespace app\components\behaviors;

trait GetImageBehavior
{
    public function getImage(): string
    {
        $array = explode('\\', __CLASS__);
        $folder_name = strtolower($array[count($array) - 1]);
        
        return '/uploads/' . $folder_name . '/' . $this->image;
    }
}