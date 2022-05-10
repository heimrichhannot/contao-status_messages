<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\StatusMessages\Asset;


use HeimrichHannot\EncoreBundle\Asset\FrontendAsset as EncoreFrontendAsset;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class FrontendAsset implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function addFrontendAssets(): void
    {
        $GLOBALS['TL_JAVASCRIPT']['huh_statusmessages'] = 'bundles/heimrichhannotstatusmessages/assets/contao-status-messages.js|static';

        if (class_exists(EncoreFrontendAsset::class) && $this->container->has(EncoreFrontendAsset::class)) {
            $this->container->get(EncoreFrontendAsset::class)->addActiveEntrypoint('contao-status-messages');
        }
    }

    public static function getSubscribedServices()
    {
        return [
            '?'.EncoreFrontendAsset::class
        ];
    }
}
