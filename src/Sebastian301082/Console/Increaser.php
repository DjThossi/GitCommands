<?php

namespace Sebastian301082\Console;


class Increaser
{
    /**
     * @param $currentTag
     * @return string
     */
    public function majorPlusOne($currentTag)
    {
        return $currentTag[0] + 1 . '.' . 0 . '.' . 0;
    }

    /**
     * @param $currentTag
     * @return string
     */
    public function minorPlusOne($currentTag)
    {
        return $currentTag[0] . '.' . ($currentTag[1] + 1) . '.' . 0;
    }

    /**
     * @param $currentTag
     * @return string
     */
    public function fixPlusOne($currentTag)
    {
        return $currentTag[0] . '.' . $currentTag[1] . '.' . ($currentTag[2] + 1);
    }
}