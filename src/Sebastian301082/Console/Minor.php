<?php
namespace Sebastian301082\Console;

class Minor
{
    /**
     * @return string
     */
    public function minorPlusOne($tagsArray)
    {
        $arrayWithSplitTagNumbers = array();
        $majorNumbers = array();
        $major = null;
        $minor = null;
        $result = null;
        foreach ($tagsArray as $tags) {
            $arrayWithSplitTagNumbers[] = explode('.', $tags);
        }

        foreach ($arrayWithSplitTagNumbers as $key) {
            $majorNumbers[] = intval($key[0]);
        }

        $highestMajorNumber = max($majorNumbers);

        foreach ($arrayWithSplitTagNumbers as $tagNumbers) {
            if ($tagNumbers[0] == $highestMajorNumber) {
                $major = strval($highestMajorNumber);
                $minor = $tagNumbers[1] + 1;
            }
        }
        $result = $major . '.' . $minor . '.' . 0;

        return $result;
    }
}