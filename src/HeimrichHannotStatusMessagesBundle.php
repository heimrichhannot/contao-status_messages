<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\StatusMessages;


use HeimrichHannot\StatusMessages\DependencyInjection\StatusMessagesExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotStatusMessagesBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new StatusMessagesExtension();
    }

}