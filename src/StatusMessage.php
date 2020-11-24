<?php

namespace HeimrichHannot\StatusMessages;

use Contao\ModuleModel;
use Contao\System;
use HeimrichHannot\StatusMessages\FrontendModule\StatusMessagesModule;

class StatusMessage
{
    const GENERAL      = 'general';

    const TYPE_ERROR   = 'MSG_ERROR';
    const TYPE_SUCCESS = 'MSG_SUCCESS';
    const TYPE_INFO    = 'MSG_INFO';
    const TYPE_RAW     = 'MSG_RAW';

    public static function addError($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, static::TYPE_ERROR, $intModule ?: static::GENERAL, $strClass);
	}

	public static function addSuccess($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, self::TYPE_SUCCESS, $intModule, $strClass);
	}

	public static function addInfo($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, self::TYPE_INFO, $intModule, $strClass);
	}

	public static function addRaw($strMessage, $intModule = 0, $strClass = '')
	{
		static::add($strMessage, self::TYPE_RAW, $intModule, $strClass);
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

    /**
     * Generate messages for given context
     *
     * Options:
     * * module: (array) Used as row for the ModuleModel passed to the StatusMessagesModule which is used to generate the messages. You can set for example customTpl to use a custom template.
     *
     * @param int|string $context A module id or other identifiert to group the messages
     * @param false $blnSkipGeneral Skip general messages
     * @param array $options Add additional options
     * @return string
     */
	public static function generate($context = 0, $blnSkipGeneral = false, array $options = [])
	{

		if (static::isEmpty($context)) {
			return '';
		}

        $moduleModel     = new ModuleModel();
		if (isset($options['module']) && is_array($options['module'])) {
		    $moduleModel->setRow($options['module']);
        }
        $objModule       = new StatusMessagesModule($moduleModel);
		$objModule->type = 'status_messages';

		return $objModule->generate(true, $context, $blnSkipGeneral);
	}

    /**
     * @param int $intVisibleModule
     * @param false $blnSkipGeneral
     * @return array|\stdClass[]
     */
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
                $arrMessages = array_merge($arrMessages, $flashBag->get(static::getFlashBagKey($strType, static::GENERAL)) ?: []);
            }

            foreach (array_unique($arrMessages) as $arrMessage)
            {
                $strFormatted = '';

                if ($strType != self::TYPE_RAW) {
                    $strFormatted = sprintf('<div class="%s" role="alert">%s</div>%s',
                        $strClass . ($arrMessage['class'] ? ' ' . $arrMessage['class'] : ''), $arrMessage['text'], "\n");
                }

                $message = new \stdClass();
                $message->text = $arrMessage['text'];
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
                return false;
            }
        }

        return true;
	}

	public static function getTypes()
	{
		return array(self::TYPE_ERROR, self::TYPE_SUCCESS, self::TYPE_INFO, self::TYPE_RAW);
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