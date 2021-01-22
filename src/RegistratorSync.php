<?php

namespace bxrocketeer;

use bxrocketeer\tasks\SetComposerAsExecutable;
use bxrocketeer\tasks\CreateShared;
use bxrocketeer\tasks\CleanBitrixCache;

/**
 * Плагин, который регистрирует все таски для упрощения деплоя на битриксе
 * с помощью rsync.
 */
class RegistratorSync extends Registrator
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
            'task' => 'dependencies',
            'handler_class' => CleanBitrixCache::class,
        ],
    ];
}
