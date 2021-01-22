<?php

namespace bxrocketeer\tasks;

use Rocketeer\Abstracts\AbstractTask;

/**
 * Очищает кэш битрикса.
 */
class CleanBitrixCache extends AbstractTask
{
    /**
     * @var string
     */
    protected $description = 'Cleaning bitrix cache';

    /**
     * @inheritdoc
     */
    public function execute(): string
    {
        $this->command->info($this->description);

        // Битрикс на лету начинает генерировать только что удалённый кэш, из-за чего процесс может затянуться.
        $clearCommands = [
            'mv web/bitrix/cache web/bitrix/cache-old',
            'rm -Rf web/bitrix/cache-old',
            'mv web/bitrix/managed_cache web/bitrix/managed_cache-old',
            'rm -Rf web/bitrix/managed_cache-old',
        ];

        $releasePath = rtrim($this->releasesManager->getCurrentReleasePath(), '/');
        $getListCommand = $this->php()->getCommand("-d short_open_tag=On -f {$releasePath}/cli.php list");
        $listOfAvailableCommands = $this->runRaw($getListCommand);
        if (mb_strpos($listOfAvailableCommands, 'base:cache.clear') !== false) {
            $clearCacheCommand = $this->php()->getCommand('-d short_open_tag=On -f cli.php base:cache.clear --quiet');
            array_unshift($clearCommands, $clearCacheCommand);
        }

        return $this->runForCurrentRelease($clearCommands);
    }
}
