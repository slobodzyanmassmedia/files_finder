<?php

namespace Massmedia\FilesFinderBundle\Services;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Find file by content
 *
 * Class FilesFinder
 * @package AppBundle\Services
 */
class FilesFinder
{
    /**
     * Search files in given directory by content
     *
     * @param $dir
     * @param $text
     * @return array
     */
    public function search($dir, $text) {
        $finder = new Finder();
        $files = $finder->files()->in($dir)->contains($text);
        $founded = [];
        foreach($files as $file) {
            $founded[] = $file->getRealPath();
        }
        return $founded;
    }

}
