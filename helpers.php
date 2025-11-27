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
function loadView($name, $data = []): void
{
    $viewPath = basePath(path: "App/views/{$name}.view.php");

    if (file_exists(filename: $viewPath)) {
        extract(array: $data); // converts the key of the assoc array into a variable 
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
function loadPartial($name, $data = []): void
{
    $partialPath = basePath(path: "App/views/partials/{$name}.php");

    if (file_exists(filename: $partialPath)) {
        extract(array: $data);
        require $partialPath;
    } else {
        echo "Partial '{$name}' not found!";
    }
}

/**
 * Inspect a value(s)
 *
 * @param mixed $value
 * @return void
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
 * @return void
 */
function inspectAndDie($value): void
{
    echo '<pre>';
    var_dump(value: $value);
    echo '</pre>';
    die();
}

/**
 * Format salary
 * 
 * @param string $salary
 * @return string Formatted Salary
 */
function formatSalary($salary): string
{
    return '$' . number_format(num: floatval(value: $salary), thousands_separator: ',');
}

/**
 * Sanitize Data
 * 
 * @param string $dirty
 * @return string
 */
function sanitize($dirty): string
{
    return filter_var(value: trim(string: $dirty), filter: FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to a given URL
 * 
 * @param string $url
 * @return void
 */
function redirect($url): void {
    header(header: "Location: {$url}");
}