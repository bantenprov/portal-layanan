<?php

namespace Bantenprov\Layanan\Console\Commands;

use Illuminate\Console\Command;

/**
 * The LayananCommand class.
 *
 * @package Bantenprov\Layanan
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class LayananCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bantenprov:layanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo command for Bantenprov\Layanan package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Welcome to command for Bantenprov\Layanan package');
    }
}
