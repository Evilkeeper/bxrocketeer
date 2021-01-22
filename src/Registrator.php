<?php

namespace bxrocketeer;

use bxrocketeer\tasks\SetComposerAsExecutable;
use Rocketeer\Abstracts\AbstractPlugin;
use Rocketeer\Exceptions\TaskCompositionException;
use Rocketeer\Services\TasksHandler;
use bxrocketeer\tasks\CreateShared;
use bxrocketeer\tasks\PrepareSshForGit;
use bxrocketeer\tasks\CleanRocketeerData;
use bxrocketeer\tasks\CleanBitrixCache;
use bxrocketeer\tasks\CheckBitrixDeploy;

/**
 * Плагин, который регистрирует все таски для упрощения деплоя на битриксе.
 */
class Registrator extends AbstractPlugin
{
    /**
     * @var array
     */
    protected $events = [
        [
            'event' => 'before',
            'task' => 'dependencies',
            'handler_class' => SetComposerAsExecutable::class,
        ],
        [
            'event' => 'after',
            'task' => 'setup',
            'handler_class' => CreateShared::class,
        ],
        [
            'event' => 'after',
            'task' => 'setup',
            'handler_class' => PrepareSshForGit::class,
        ],
        [
            'event' => 'after',
            'task' => 'deploy',
            'handler_class' => CleanRocketeerData::class,
        ],
        [
            'event' => 'after',
            'task' => 'dependencies',
            'handler_class' => CleanBitrixCache::class,
        ],
        [
            'event' => 'before',
            'task' => 'primer',
            'handler_class' => CheckBitrixDeploy::class,
        ],
    ];

    /**
     * {@inheritdoc}
     * @throws TaskCompositionException
     */
    public function onQueue(TasksHandler $queue): void
    {
        foreach ($this->events as $event) {
            $queue->addTaskListeners(
                $event['task'],
                $event['event'],
                $event['handler_class'],
                -10,
                true
            );
        }
    }
}
