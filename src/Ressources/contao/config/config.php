<?php

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['status_messages'] = \HeimrichHannot\StatusMessages\StatusMessagesModule::class;

/**
 * Javascript
 */
if (TL_MODE == 'FE') {
	$GLOBALS['TL_JAVASCRIPT']['jquery.statusmessages'] = 'system/modules/status_messages/assets/js/jquery.statusmessages.js|static';
}

$GLOBALS['TL_COMPONENTS']['jquery.statusmessages'] = [
    'js'  => [
        'system/modules/status_messages/assets/js/jquery.statusmessages.js|static',
    ],
];