<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_database_connection_is_mysql(): void
    {
        $config = $this->withoutEnv(['DB_CONNECTION'], fn () => require config_path('database.php'));

        $this->assertSame('mysql', $config['default']);
    }

    public function test_mysql_connection_is_configured(): void
    {
        $config = $this->withoutEnv([
            'DB_CONNECTION',
            'DB_HOST',
            'DB_PORT',
            'DB_DATABASE',
            'DB_USERNAME',
            'DB_PASSWORD',
        ], fn () => require config_path('database.php'));

        $mysql = $config['connections']['mysql'];

        $this->assertSame('mysql', $mysql['driver']);
        $this->assertSame('127.0.0.1', $mysql['host']);
        $this->assertSame('3306', $mysql['port']);
        $this->assertSame('laravel', $mysql['database']);
        $this->assertSame('root', $mysql['username']);
        $this->assertSame('utf8mb4', $mysql['charset']);
        $this->assertSame('utf8mb4_unicode_ci', $mysql['collation']);
    }

    public function test_all_migrations_create_expected_tables(): void
    {
        foreach ([
            'users',
            'password_reset_tokens',
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
            'contacts',
        ] as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Expected [{$table}] table to exist after migrations."
            );
        }
    }

    private function withoutEnv(array $keys, callable $callback): mixed
    {
        $backup = [];

        foreach ($keys as $key) {
            $backup[$key] = [
                'getenv' => getenv($key),
                'has_env' => array_key_exists($key, $_ENV),
                'has_server' => array_key_exists($key, $_SERVER),
                'env' => $_ENV[$key] ?? null,
                'server' => $_SERVER[$key] ?? null,
            ];

            putenv($key);
            unset($_ENV[$key], $_SERVER[$key]);
        }

        try {
            return $callback();
        } finally {
            foreach ($backup as $key => $previous) {
                if ($previous['getenv'] === false) {
                    putenv($key);
                } else {
                    putenv("{$key}={$previous['getenv']}");
                }

                if ($previous['has_env']) {
                    $_ENV[$key] = $previous['env'];
                }

                if ($previous['has_server']) {
                    $_SERVER[$key] = $previous['server'];
                }
            }
        }
    }
}
