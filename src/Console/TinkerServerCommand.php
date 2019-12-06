<?php


namespace Guetteman\LaravelTinkerServer\Console;


use Clue\React\Stdio\Stdio;
use Guetteman\LaravelTinkerServer\Shell\ExecutionClosure;
use Illuminate\Console\Command;
use Psy\Configuration;
use Psy\Shell;
use React\EventLoop\Factory;
use Symfony\Component\Console\Output\BufferedOutput;

class TinkerServerCommand extends Command
{
    protected $signature = 'tinker-server';

    /**
     * @var BufferedOutput
     */
    protected $shellOutput;

    public function handle()
    {
        $this->shellOutput = new BufferedOutput();

        $loop = Factory::create();
        $stdio = new Stdio($loop);

        $shell = $this->createPsyShell();

        $stdio->setPrompt('>> ');

        $stdio->on('data', function ($line) use ($stdio, $shell) {
            $line = rtrim($line, "\r\n");

            $shell->addInput($line);

            $clousure = new ExecutionClosure($shell, $line);
            $clousure->execute();

            $stdio->write($this->shellOutput->fetch());
        });

        $loop->run();
    }

    protected function createPsyShell()
    {
        $config = new Configuration([
            'updateCheck' => 'never'
        ]);

        $config->getPresenter()->addCasters(
            $this->getCasters()
        );

        $shell = new Shell($config);
        $shell->setOutput($this->shellOutput);

        return $shell;
    }

    /**
     * Get an array of Laravel tailored casters.
     *
     * @return array
     */
    protected function getCasters()
    {
        $casters = [
            'Illuminate\Support\Collection' => 'Laravel\Tinker\TinkerCaster::castCollection',
        ];
        if (class_exists('Illuminate\Database\Eloquent\Model')) {
            $casters['Illuminate\Database\Eloquent\Model'] = 'Laravel\Tinker\TinkerCaster::castModel';
        }
        if (class_exists('Illuminate\Foundation\Application')) {
            $casters['Illuminate\Foundation\Application'] = 'Laravel\Tinker\TinkerCaster::castApplication';
        }
        return $casters;
    }

}
