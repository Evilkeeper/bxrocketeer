<?php

namespace bxrocketeer\tasks;

use Rocketeer\Abstracts\AbstractTask;

/**
 * Делает файл composer.phar внутри проекта исполняемым для того, чтобы обойти
 * ограничения, связанные с тем, что windows не пишет права на файл в git.
 */
class SetComposerAsExecutable extends AbstractTask
{
    /**
     * @var string
     */
    protected $description = 'Make composer.phar executable';

    /**
     * @inheritdoc
     */
    public function execute(): string
    {
        $this->command->info($this->description);

        return $this->runForCurrentRelease('chmod 0770 composer.phar');
    }
}
