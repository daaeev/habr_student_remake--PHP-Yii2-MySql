<?php

namespace app\components\lib;

class HtmlGenHelper
{   
    protected static function generateButton($class, $title)
    {
        return '<button type="button" class="' . $class . '">' . $title . '</button>';
    }
}