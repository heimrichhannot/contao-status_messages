<?php

namespace HeimrichHannot\StatusMessages;

use Contao\ModuleModel;
use Contao\System;

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
        if ($strMessage == '')
        {
            return;
        }

        if (!\in_array($strType, static::getTypes()))
        {
            throw new \LogicException("Invalid message type $strType");
        }

        System::getContainer()->get('session')->getFlashBag()->add(static::getFlashBagKey($strType, $intModule), [
            'text' => $strMessage,
            'class' => $strClass
        ]);
	}

	public static function generate($intModuleId = 0, $blnSkipGeneral = false)
	{
		if (static::isEmpty($intModuleId)) {
			return '';
		}

		$objModule = new StatusMessagesModule(new ModuleModel());
		$objModule->type = 'status_messages';

		return $objModule->generate(true, $intModuleId, $blnSkipGeneral);
	}

	public static function getAll($intVisibleModule = 0, $blnSkipGeneral = false): array
	{
        $session = System::getContainer()->get('session');
        $messages = [];

        if (!$session->isStarted())
        {
            return $messages;
        }

        $flashBag = $session->getFlashBag();

        foreach (static::getTypes() as $strType)
        {
            $strClass = strtolower(str_replace('_', '-', $strType));
            $arrMessages = $flashBag->get(static::getFlashBagKey($strType, $intVisibleModule));
            if (!$blnSkipGeneral) {
                $arrMessage = array_merge($arrMessage, $flashBag->get(static::getFlashBagKey($strType, static::GENERAL)));
            }

            foreach (array_unique($arrMessages) as $arrMessage)
            {
                $strFormatted = '';

                if ($strType != 'MSG_RAW') {
                    $strFormatted = sprintf('<div class="%s" role="alert">%s</div>%s',
                        $strClass . ($arrMessage['class'] ? ' ' . $arrMessage['class'] : ''), $arrMessage['text'], "\n");
                }

                $message = new \stdClass();
                $message->message = $arrMessage['text'];
                $message->type = $strType;
                $message->class = $strClass;
                $message->formatted = $strFormatted;
                $messages[] = $message;
            }
        }

        return $messages;
	}

	public static function reset($intVisibleModule, $blnSkipGeneral=false)
	{
        $session = System::getContainer()->get('session');

        if (!$session->isStarted())
        {
            return;
        }

        $flashBag = $session->getFlashBag();

		foreach (static::getTypes() as $strType) {
            $flashBag->get(static::getFlashBagKey($strType, $intVisibleModule));
		}
	}

    /**
     * Reset the message system
     */
	public static function resetAll()
	{
        $session = System::getContainer()->get('session');

        if (!$session->isStarted())
        {
            return;
        }

        $session->getFlashBag()->clear();
	}

	public static function isEmpty($intModule = 0): bool
	{
        $session = System::getContainer()->get('session');

        if (!$session->isStarted())
        {
            return true;
        }

        $flashBag = $session->getFlashBag();

        foreach (static::getTypes() as $strType) {
            if ($flashBag->has(static::getFlashBagKey($strType, $intModule))) {
                return true;
            }
        }

        return false;
	}

	public static function getTypes()
	{
		return array('MSG_ERROR', 'MSG_SUCCESS', 'MSG_INFO', 'MSG_RAW');
	}

    /**
     * Return the flash bag key
     *
     * @param string      $strType  The message type
     * @param string|int $moduleId The message scope
     *
     * @return string The flash bag key
     */
    protected static function getFlashBagKey($strType, $moduleId = self::GENERAL)
    {
        return 'huh_statusmessages.' . $moduleId . '.' . strtolower(str_replace('TL_', '', $strType));
    }

}