<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Status_messages
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'HeimrichHannot\StatusMessages\ModuleStatusMessages' => 'system/modules/status_messages/modules/ModuleStatusMessages.php',

	// Classes
	'HeimrichHannot\StatusMessages\StatusMessage'        => 'system/modules/status_messages/classes/StatusMessage.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_status_messages' => 'system/modules/status_messages/templates',
));
