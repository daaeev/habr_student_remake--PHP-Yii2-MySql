<?php

namespace app\components;

trait GetImageBehavior
{
    public function getImage(): string
    {
        return '/uploads/tags/' . $this->image;
    }
}