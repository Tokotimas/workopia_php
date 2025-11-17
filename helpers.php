<?php declare(strict_types=1);

/**
 * Get the base path
 *
 * @param string $path
 * @return string
 */
function basePath($path = ''): string
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 *
 * @param string $name
 * @return void
 */
function loadView($name): void
{
    $viewPath = basePath(path: "views/{$name}.view.php");

    if (file_exists(filename: $viewPath)) {
        require $viewPath;
    } else {
        echo "View '{$name}' not found!";
    }
}

/**
 * Load a partial
 *
 * @param string $name
 * @return void
 */
function loadPartial($name): void
{
    $partialPath = basePath(path: "views/partials/{$name}.php");

    if (file_exists(filename: $partialPath)) {
        require $partialPath;
    } else {
        echo "View '{$name}' not found!";
    }
}

/**
 * Inspect a value(s)
 *
 * @param mixed $value
 * return void
 */
function inspect($value): void
{
    echo '<pre>';
    var_dump(value: $value);
    echo '</pre>';
}

/**
 * Inspect a value(s) and die
 *
 * @param mixed $value
 * return void
 */
function inspectAndDie($value): void
{
    echo '<pre>';
    die(var_dump(value: $value));
}
