<?php

namespace app\components;

trait AuthorCheckBehavior
{
    public function isAuthor($user)
    {
        if ($this->author->id == @$user->id)
            return true;
    }
}