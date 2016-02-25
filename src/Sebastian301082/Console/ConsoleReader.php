<?php
namespace Sebastian301082\Console;

use Exception;

/**
 * @author Sebastian Thoss
 */
class ConsoleReader
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!defined('STDIN')) {
            throw new Exception("Can't read on STDIN. It's not defined");
        }
    }

    /**
     * @return string
     */
    public function read()
    {
        return trim(fgets(STDIN));
    }
}