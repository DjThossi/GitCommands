<?php
use Sebastian301082\Factory;

require_once 'vendor/autoload.php';

$factory = new Factory();
$consoleWriter = $factory->createConsoleWriter();
$consoleQuestions = $factory->createConsoleQuestions();
$highestVersion = $factory->createHighestVersion();
$increaser = $factory->createIncreaser();

const CACHE_FILE_NAME = 'cache.php';
const PROJECT = 'project';
const SOURCE = 'source';
const DESTINATION = 'destination';
const WHICH_TAG = 'T';
const WHICH_BRANCH = 'B';
const WHICH = 'Which';

$data = [
    PROJECT => null,
    SOURCE => 'develop',
    DESTINATION => 'master',
    WHICH => WHICH_TAG,
];

if (is_file(CACHE_FILE_NAME)) {
    $data = array_merge($data, require_once(CACHE_FILE_NAME));
}

$consoleWriter->writeLine("Start Release");

$data[PROJECT] = $consoleQuestions->ask('Which project to release? Please provide path', $data[PROJECT]);

if (!is_dir($data[PROJECT])) {
    throw new Exception('Provided path not found');
}

chdir($data[PROJECT]);

$result = `git status;`;
if (strpos($result, 'nothing to commit') === false) {
    throw new Exception('git status is not clean');
}

$data[SOURCE] = $consoleQuestions->ask('Which source branch to take?', $data[SOURCE]);
$data[DESTINATION] = $consoleQuestions->ask('Which destination branch to take?', $data[DESTINATION]);

`git fetch;`;
$result = `git tag;`;
$tag = '0.0.1';
if ($result !== null) {
    $tagNumber[] = null;
    foreach (explode(PHP_EOL, $result) as $line) {
        $matches = [];
        preg_match('/[0-9]{1,}.[0-9]{1,}.[0-9]{1,}/', $line, $matches);

        if (empty($matches)) {
            continue;
        }

        $explodedTag = explode('.', $matches[0]);
        $tagNumber[] = $explodedTag[0] . '.' . $explodedTag[1] . '.' . $explodedTag[2];
    }

    $tag = $highestVersion->getHighestVersion($tagNumber);

    $consoleWriter->writeLine($result);


    echo "Which number you want to increase? 0 for major | 1 for minor | 2 for fix | 3 for manual :";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) == '0') {

        echo "\n";
        echo $increaser->majorPlusOne($tag);
        echo "\n";
        echo "\n";
        echo "Is this correct? y/n ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) == 'y') {
            $tag = $increaser->majorPlusOne($tag);
        } else {
            $consoleQuestions->ask('Which is your next Release tag?');
        }
    }

    if (trim($line) == '1') {
        echo "\n";
        echo $increaser->minorPlusOne($tag);
        echo "\n";
        echo "\n";
        echo "Is this correct? y/n ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) == 'y') {
            $tag = $increaser->minorPlusOne($tag);

        } else {
            $consoleQuestions->ask('Which is your next Release tag?');
        }
    }

    if (trim($line) == '2') {
        echo "\n";
        echo $increaser->fixPlusOne($tag);
        echo "\n";
        echo "\n";
        echo "Is this correct? y/n ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) == 'y') {
            $tag = $increaser->fixPlusOne($tag);
        } else {
            $consoleQuestions->ask('Which is your next Release tag?');
        }
    }

    if (trim($line) == '3') {
        $consoleQuestions->ask('Which is your next Release tag?');
    }

} else {
    $consoleQuestions->ask('No tags created yet. Which is your fist Release tag?', implode($tag));
}

    $tag = $consoleQuestions->ask('No tags created yet. Which is your fist Release tag?', $tag);

$data[WHICH] = $consoleQuestions->ask('Do you want to create Tag (T) or Branch (B)', $data[WHICH]);

`git checkout {$data[SOURCE]} && git pull`;
if ($data[WHICH] === 'T') {
`git tag {$tag} && git push --tags`;
`git checkout {$data[DESTINATION]} && git pull && git merge {$tag} && git push origin {$data[DESTINATION]}`;
}

file_put_contents(__DIR__ . '/cache.php', "<?php \n\n return " . var_export($data, true) . ';');

$consoleWriter->writeLine("Release finished");
