<?php


namespace Guetteman\LaravelTinkerServer\Console;


use Illuminate\Console\Command;

class TinkerServerCommand extends Command
{
    protected $signature = 'tinker-server';

    public function handle()
    {
        $this->info('Perform magic tricks');
    }
}
