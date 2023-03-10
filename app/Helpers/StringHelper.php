<?php

namespace App\Helpers;

//TODO: Maybe delete this? Not sure if this is goona be used anywhere
class StringHelper
{
    public static function sluggable(string $field): string
    {
        return strtolower(str_replace(' ', '-', $field));
    }
}
