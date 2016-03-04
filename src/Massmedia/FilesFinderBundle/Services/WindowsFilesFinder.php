<?php

namespace Massmedia\FilesFinderBundle\Services;

/**
 * Find files using Windows findstr http://ss64.com/nt/findstr.html
 *
 * Class WindowsFilesFinder
 * @package Massmedia\FilesFinderBundle\Services
 */
class WindowsFilesFinder implements FilesFinderInterface
{
    /**
     * @inheritdoc
     */
    public function search($dir, $text)
    {
        $text = addcslashes($text, '"');
        $dir = addcslashes($dir, '"');

        // Execute windows "findstr" command
        exec("findstr /SM \"$text\" \"$dir\\*\"", $results, $returnVar);

        if ($returnVar > 0) {
            throw new \RuntimeException("Error find files in directory $dir using findstr");
        }

        // Prepare results
        $results = array_filter($results);
        foreach ($results as &$line) {
            $line = realpath($line);
        }

        return $results;
    }

}
