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


use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

class FrontendAsset implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function addFrontendAssets(): void
    {
        $GLOBALS['TL_JAVASCRIPT']['huh_statusmessages'] = 'bundles/heimrichhannotstatusmessages/assets/contao-status-messages.js|static';

        if ($this->container->has('HeimrichHannot\EncoreBundle\Asset\FrontendAsset')) {
            $this->container->get(\HeimrichHannot\EncoreBundle\Asset\FrontendAsset::class)->addActiveEntrypoint('contao-status-messages');
        }
    }

    public static function getSubscribedServices()
    {
        return [
            '?HeimrichHannot\EncoreBundle\Asset\FrontendAsset'
        ];
    }
}