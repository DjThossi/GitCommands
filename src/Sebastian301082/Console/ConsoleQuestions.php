<?php
namespace Sebastian301082\Console;

/**
 * @author Sebastian Thoss
 */
class ConsoleQuestions
{
    /**
     * @var ConsoleReader
     */
    private $consoleReader;
    /**
     * @var ConsoleWriter
     */
    private $consoleWriter;

    /**
     * @param ConsoleReader $consoleReader
     * @param ConsoleWriter $consoleWriter
     */
    public function __construct(ConsoleReader $consoleReader, ConsoleWriter $consoleWriter)
    {
        $this->consoleReader = $consoleReader;
        $this->consoleWriter = $consoleWriter;
    }

    /**
     * @param $message
     * @param string $defaultAnswer
     *
     * @return string
     */
    public function ask($message, $defaultAnswer = '')
    {
        $this->consoleWriter->write($message);

        if (strlen($defaultAnswer) > 0) {
            $this->consoleWriter->write(
                sprintf(' [%s]', $defaultAnswer)
            );
        }

        $this->consoleWriter->write(':');

        $answer = $this->consoleReader->read();

        if (strlen($answer) === 0) {
            return $defaultAnswer;
        }

        return $answer;
    }
}