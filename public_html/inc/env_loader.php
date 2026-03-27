<?php
/**
 * Environment Loader for YDI Educational Platform
 *
 * This file loads environment variables from .env file
 *
 * @version 1.0
 * @php 8.3 compatible
 */

class EnvLoader
{
    private static bool $loaded = false;
    private static array $env = [];

    /**
     * Load environment variables from .env file
     */
    public static function load(string $path = null): void
    {
        if (self::$loaded) {
            return;
        }

        // Default: look for .env in public_html root
        $envFile = $path ?? dirname(__DIR__) . '/.env';

        if (!file_exists($envFile)) {
            throw new RuntimeException("Environment file not found: {$envFile}");
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                $value = trim($value, '"\'');

                // Store in our cache
                self::$env[$key] = $value;

                // Set as environment variable
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Get an environment variable
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$env[$key] ?? getenv($key) ?: $default;
    }

    /**
     * Check if an environment variable is set
     */
    public static function has(string $key): bool
    {
        if (!self::$loaded) {
            self::load();
        }

        return isset(self::$env[$key]) || getenv($key) !== false;
    }
}

/**
 * Helper function to get environment variables
 */
function env(string $key, mixed $default = null): mixed
{
    return EnvLoader::get($key, $default);
}

// Auto-load environment on include
EnvLoader::load();
