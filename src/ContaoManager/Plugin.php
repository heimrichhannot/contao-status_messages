<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\StatusMessages\ContaoManager;


use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use HeimrichHannot\StatusMessages\HeimrichHannotStatusMessagesBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(HeimrichHannotStatusMessagesBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}