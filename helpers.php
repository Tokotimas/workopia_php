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
