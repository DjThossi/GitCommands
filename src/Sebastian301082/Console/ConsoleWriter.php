<?php
namespace Sebastian301082\Console;
use Exception;

/**
 * @author Sebastian Thoss
 */
class ConsoleWriter
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!defined('STDOUT')) {
            throw new Exception("Can't write on STDOUT. It's not defined");
        }
    }

    /**
     * @param $message
     */
    public function write($message)
    {
       fwrite(STDOUT, $message);
    }

    /**
     * @param $message
     */
    public function writeLine($message)
    {
       fwrite(STDOUT, rtrim($message, PHP_EOL) . PHP_EOL);
    }
}