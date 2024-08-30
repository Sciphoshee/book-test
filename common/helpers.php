<?php


/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env(string $key, mixed $default = null): mixed
{
    // getenv is disabled when using createImmutable with Dotenv class
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    } elseif (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }

    return $default;
}

function dumpVar($var, $title = null, bool $usePrintr = false) :void
{
    $isConsoleApp = \Yii::$app instanceof \yii\console\Application;

    $lineSeparator = $isConsoleApp ? PHP_EOL : '<br>';
    if ($title) {
        echo $title . $lineSeparator;
    }
    if (is_string($var) || is_numeric($var)) {
        echo $var . $lineSeparator;
    } else {
        if (!$isConsoleApp) {
            echo '<pre>';
        }

        if ($usePrintr) {
            print_r($var);
        } else {
            var_dump($var);
        }

        if (!$isConsoleApp) {
            echo '</pre>';
        }
    }
    echo $lineSeparator;
}