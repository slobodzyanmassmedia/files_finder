<?php

namespace Massmedia\FilesFinderBundle\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class FilesFinderConfigurator
 * @package Massmedia\FilesFinderBundle\Services
 */
class FilesFinderConfigurator
{
    /**
     * Configure files finder service
     *
     * @param FilesFinder $filesFinder
     */
    public function configure(FilesFinder $filesFinder)
    {
        switch (strtolower(PHP_OS)) {
            case 'win':
                $finder = new WindowsFilesFinder();
                break;
            case 'linux':
                $finder = new LinuxFilesFinder();
                break;
            default:
                throw new \RuntimeException('Unknown operating system');
        }

        $filesFinder->setFinder($finder);
    }

}
