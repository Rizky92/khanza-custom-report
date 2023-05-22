<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Encryption\Encrypter;

class GenerateImpersonateKey extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'impersonate-key:generate
        {--show : Display the key instead of modifying files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the impersonation key';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $key = $this->generateRandomKey();

        if ($this->option('show')) {
            $this->line('<comment>'.$key.'</comment>');
        }

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($key)) {
            return;
        }

        $this->laravel['config']['laravel-impersonate.session_key'] = $key;

        $this->info('Impersonation key set successfully.');
    }

    /**
     * Generate a random key for the application.
     */
    protected function generateRandomKey(): string
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey($this->laravel['config']['app.cipher'])
        );
    }

    /**
     * Set the impersonation key in the environment file.
     */
    protected function setKeyInEnvironmentFile(string $key): bool
    {
        $currentKey = $this->laravel['config']['laravel-impersonate.session_key'];

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     */
    protected function writeNewEnvironmentFileWith(string $key): void
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern(),
            'IMPERSONATE_KEY='.$key,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env IMPERSONATE_KEY with any random key.
     */
    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('='.$this->laravel['config']['laravel-impersonate.session_key'], '/');

        return "/^IMPERSONATE_KEY{$escaped}/m";
    }
}
