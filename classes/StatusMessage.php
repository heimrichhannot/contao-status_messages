<?php

namespace HeimrichHannot\StatusMessages;

use Haste\Data\Collection;
use Haste\Data\Plain;

class StatusMessage
{
	const GENERAL = 'general';

	public static function addError($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, 'MSG_ERROR', $intModule ?: static::GENERAL, $strClass);
	}

	public static function addSuccess($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, 'MSG_SUCCESS', $intModule, $strClass);
	}

	public static function addInfo($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, 'MSG_INFO', $intModule, $strClass);
	}

	public static function addRaw($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, 'MSG_RAW', $intModule, $strClass);
	}

	public static function add($strMessage, $strType, $intModule, $strClass)
	{
		if ($strMessage == '') {
			return;
		}

		if (!in_array($strType, static::getTypes())) {
			throw new \LogicException("Invalid message type $strType");
		}

		if (!is_array($_SESSION[$strType])) {
			$_SESSION[$strType] = array();
		}

		if (!is_array($_SESSION[$strType][$intModule])) {
			$_SESSION[$strType][$intModule] = array();
		}

		$_SESSION[$strType][$intModule][] = array(
			'text' => $strMessage,
			'class' => $strClass
		);
	}

	public static function generate($intModuleId = 0, $blnSkipGeneral = false)
	{
		if (static::isEmpty($intModuleId)) {
			return '';
		}

		$objModule = new ModuleStatusMessages(new \ModuleModel());
		$objModule->type = 'status_messages';

		return $objModule->generate(true, $intModuleId, $blnSkipGeneral);
	}

	public static function getAll($intVisibleModule = 0, $blnSkipGeneral = false)
	{
		$arrMessages = array();

		foreach (static::getTypes() as $strType) {
			if (empty($_SESSION[$strType])) {
				continue;
			}

			foreach ($_SESSION[$strType] as $intModule => $arrTexts)
			{
				if ($intModule == $intVisibleModule || !$blnSkipGeneral && $intModule == static::GENERAL)
				{
					$strClass = strtolower(str_replace('_', '-', $strType));

					$_SESSION[$strType][$intModule] = array_unique($_SESSION[$strType][$intModule]);

					foreach ($arrTexts as $arrMessage) {
						$strFormatted = '';

						if ($strType != 'MSG_RAW') {
							$strFormatted = sprintf('<div class="%s" role="alert">%s</div>%s',
									$strClass . ($arrMessage['class'] ? ' ' . $arrMessage['class'] : ''), $arrMessage['text'], "\n");
						}

						$arrMessages[] = new Plain(
							$arrMessage['text'],
							'',
							array(
								'type'      => $strType,
								'class'     => $strClass,
								'formatted' => $strFormatted
							)
						);
					}
				}
			}
		}

		if (!$_POST) {
			static::reset($intVisibleModule, $blnSkipGeneral);
		}

		return new Collection($arrMessages);
	}

	public static function reset($intVisibleModule, $blnSkipGeneral=false)
	{
		foreach (static::getTypes() as $strType) {
			if (empty($_SESSION[$strType]))
				continue;

			foreach ($_SESSION[$strType] as $intModule => $arrTexts)
			{
				if ($intModule == $intVisibleModule || !$blnSkipGeneral && $intModule == static::GENERAL
				)
				{
					unset($_SESSION[$strType][$intModule]);
				}
			}
		}
	}

	public static function resetAll()
	{
		foreach (static::getTypes() as $strType) {
			if (empty($_SESSION[$strType]))
				continue;

			foreach ($_SESSION[$strType] as $intModule => $arrTexts)
			{
				unset($_SESSION[$strType][$intModule]);
			}
		}
	}

	public static function isEmpty($intModule = 0)
	{
		foreach (static::getTypes() as $strType) {
			if (!empty($_SESSION[$strType][$intModule])) {
				return false;
			}
		}

		return true;
	}

	public static function getTypes()
	{
		return array('MSG_ERROR', 'MSG_SUCCESS', 'MSG_INFO', 'MSG_RAW');
	}

}