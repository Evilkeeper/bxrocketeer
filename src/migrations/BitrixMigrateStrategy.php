<?php

namespace bxrocketeer\migrations;

use Rocketeer\Abstracts\Strategies\AbstractStrategy;
use Rocketeer\Interfaces\Strategies\MigrateStrategyInterface;

/**
 * Стратегия для миграций, которая использует marvin255/bxmigrate.
 */
class BitrixMigrateStrategy extends AbstractStrategy implements MigrateStrategyInterface
{
    /**
     * @var string
     */
    protected $description = 'Migrates your database with marvin255/bxmigrate';

    /**
     * {@inheritdoc}
     */
    public function migrate(): bool
    {
        $this->runForCurrentRelease([
            $this->php()->getCommand('-d short_open_tag=On -f cli.php bxmigrate:up'),
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function seed(): bool
    {
        return $this->migrate();
    }
}
