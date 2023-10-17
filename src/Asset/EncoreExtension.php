<?php

namespace HeimrichHannot\StatusMessages\Asset;

use HeimrichHannot\EncoreContracts\EncoreEntry;
use HeimrichHannot\EncoreContracts\EncoreExtensionInterface;
use HeimrichHannot\StatusMessages\HeimrichHannotStatusMessagesBundle;

class EncoreExtension implements EncoreExtensionInterface
{

    /**
     * @inheritDoc
     */
    public function getBundle(): string
    {
        return HeimrichHannotStatusMessagesBundle::class;
    }

    /**
     * @inheritDoc
     */
    public function getEntries(): array
    {
        return [
            EncoreEntry::create('contao-status-messages', 'src/Resources/assets/js/status_messages.js')
                ->addJsEntryToRemoveFromGlobals('huh_statusmessages')
        ];
    }
}