<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\StatusMessages\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class StatusMessagesExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension('huh_encore')) {
            $config = [
                'js_entries' => [
                    [
                        'name' => 'contao-status-messages',
                        'file' => 'vendor/heimrichhannot/contao-status_messages/src/Resources/assets/js/status_messages.js'
                    ]
                ],
                'unset_global_keys' => [
                    'js' => [
                        'huh_statusmessages',
                    ]
                ]
            ];
            $container->prependExtensionConfig('huh_encore', $config);
        }
    }
}