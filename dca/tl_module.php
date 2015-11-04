<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
$arrDca['palettes']['status_messages'] = '{title_legend},name,headline,type;{config_legend},visibleStatusMessages;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Fields
 */
$arrDca['fields']['visibleStatusMessages'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['visibleStatusMessages'],
	'inputType'               => 'checkbox',
	'options'                 => array('module', 'general'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['visibleStatusMessages'],
	'eval'                    => array('mandatory'=>true, 'multiple' => true, 'tl_class'=>'w50'),
	'sql'                     => "blob NULL",
);