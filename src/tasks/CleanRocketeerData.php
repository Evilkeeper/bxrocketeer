<?php

namespace bxrocketeer\tasks;

use Rocketeer\Abstracts\AbstractTask;

/**
 * Удаляет папку с настройками рокетира на площадке после деплоя.
 */
class CleanRocketeerData extends AbstractTask
{
    /**
     * @var string
     */
    protected $description = 'Remove rocketeer info files';

    /**
     * @inheritdoc
     */
    public function execute(): string
    {
        $this->command->info($this->description);

        return $this->runForCurrentRelease([
            'rm -Rf .rocketeer',
            'rm -Rf rocketeer.phar',
        ]);
    }
}
