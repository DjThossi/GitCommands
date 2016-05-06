<?php
namespace Sebastian301082\Console;

class HighestVersion
{

    public function getHighestVersion(array $array)
    {
        $minorNumbers = array();
        $highestTag = null;

        $arrayWithSplitTagNumbers = array();
        $majorNumbers = array();

        foreach ($array as $tags) {
            $arrayWithSplitTagNumbers[] = explode('.', $tags);
        }

        foreach ($arrayWithSplitTagNumbers as $key) {
            $majorNumbers[] = intval($key[0]);
            $highestMajor = max($majorNumbers);
        }

        foreach ($arrayWithSplitTagNumbers as $kei2) {
            $minorNumbers[] = intval($kei2[1]);
            $highestMinor = strval(max($minorNumbers));
        }

        foreach ($arrayWithSplitTagNumbers as $key) {
            $majorNumbers[] = intval($key[0]);
            $highestMajor = strval(max($majorNumbers));
            if ($key[0] == $highestMajor) {
                $tagsWithHighMajor[] = $key;
                $minorNumbers[] = intval($key[1]);
                $highestMinor = strval(max($minorNumbers));
                if ($key[1] == $highestMinor) {
                    $tagsWithHighMajorAndMinor[] = $key;
                    $fixNumbers[] = intval($key[2]);
                    $highestFix = strval(max($fixNumbers));
                    if ($key[2] == $highestFix) {
                        $highestTag = $key;
                    }
                }
            }
        }
        return $highestTag;
    }
}