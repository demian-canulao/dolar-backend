<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DollarService;

class SyncDollarValues extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dollar:sync {--from=2024} {--to=2025}';
    protected $description = 'Comando para sincronizar el valor del dolar a tráves de mindicador.cl por rango de fechas';

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected $service;

    public function __construct(DollarService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    public function handle()
    {
        $from = (int) $this->option('from');
        $to = (int) $this->option('to');

        $this->info("Sincronizando años {$from}..{$to}");

        try {
            $count = $this->service->syncYears($from, $to);
            $this->info("{$count} registros sincronizados");
            return 0;
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
