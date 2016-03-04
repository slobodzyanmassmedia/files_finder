<?php

namespace Massmedia\FilesFinderBundle\Services;

/**
 * Find files using Linux grep http://www.gnu.org/software/grep
 *
 * Class LinuxFilesFinder
 * @package Massmedia\FilesFinderBundle\Services
 */
class LinuxFilesFinder implements FilesFinderInterface
{
    /**
     * @inheritdoc
     */
    public function search($dir, $text)
    {
        $text = addcslashes($text, '\'');
        $dir = addcslashes($dir, '\'');

        // Execute linux "grep" command
        exec("grep -rl '$text' '$dir'", $results, $returnVar);

        if ($returnVar > 1) {
            throw new \RuntimeException("Error find files in directory $dir using grep");
        }

        // Prepare results
        $results = array_filter($results);
        foreach ($results as $key => $line) {
            $results[$key] = realpath($line);
        }

        return $results;
    }

}
