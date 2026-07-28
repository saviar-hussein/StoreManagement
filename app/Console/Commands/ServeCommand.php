<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

/**
 * Overrides the framework's built-in `serve` command.
 *
 * The frontend (frontend/login.html, frontend/index.html, etc.) lives
 * completely outside of Laravel and only talks to this app through the
 * /api routes (see frontend/js/api.js — API_BASE points at
 * http://127.0.0.1:8000/api, which matches this server's default port).
 *
 * Browsers block fetch() calls made from a file:// page to an http://
 * server, so instead of opening login.html as a raw file, this command
 * spins up PHP's built-in server just for the frontend folder (on its
 * own port), opens it in the browser, then starts the normal API dev
 * server. The frontend is still a fully separate app — it only ever
 * talks to Laravel through the /api routes.
 */
class ServeCommand extends BaseServeCommand
{
    /** @var resource|null */
    protected $frontendProcess;

    protected string $frontendHost = '127.0.0.1';

    protected int $frontendPort = 5522;

    public function handle()
    {
        $this->startFrontendServer();
        $this->openLoginPage();

        return parent::handle();
    }

    protected function startFrontendServer(): void
    {
        $frontendPath = base_path('frontend');

        if (! is_dir($frontendPath)) {
            $this->warn("Could not find {$frontendPath} — skipping frontend server.");

            return;
        }

        $command = sprintf(
            'php -S %s:%d -t %s',
            $this->frontendHost,
            $this->frontendPort,
            escapeshellarg($frontendPath)
        );

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $this->frontendProcess = proc_open($command, $descriptors, $pipes);

        // Make sure the frontend server gets killed when this process exits.
        register_shutdown_function(function () {
            if (is_resource($this->frontendProcess)) {
                proc_terminate($this->frontendProcess);
            }
        });

        // Give it a moment to boot before we try to open the browser.
        usleep(500000);

        $this->info("Frontend running at http://{$this->frontendHost}:{$this->frontendPort}");
    }

    protected function openLoginPage(): void
    {
        $url = "http://{$this->frontendHost}:{$this->frontendPort}/login.html";

        try {
            if (PHP_OS_FAMILY === 'Windows') {
                exec('cmd /c start "" "'.$url.'"');
            } elseif (PHP_OS_FAMILY === 'Darwin') {
                exec('open '.escapeshellarg($url));
            } else {
                exec('xdg-open '.escapeshellarg($url));
            }
        } catch (\Throwable $e) {
            $this->warn('Could not auto-open the browser: '.$e->getMessage());

            return;
        }

        $this->info("Opening login page: {$url}");
    }
}