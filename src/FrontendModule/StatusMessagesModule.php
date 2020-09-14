<?php

namespace HeimrichHannot\StatusMessages;

use Contao\BackendTemplate;
use Contao\Module;

class StatusMessagesModule extends Module
{

	protected $strTemplate = 'mod_status_messages';
	protected $blnGlobal;
	protected $intModuleId;
	protected $blnSkipGeneral;

	public function generate($blnLocal = false, $intModuleId = 0, $blnSkipGeneral = false)
	{
		if (TL_MODE == 'BE') {
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### STATUS MESSAGES ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		if (!$blnLocal)
			$this->cssID = array($this->cssID[0] ?: '', $this->cssID[1] ? $this->cssID[1] . 'global' : 'global');

		$this->intModuleId = $intModuleId;
		$this->blnSkipGeneral = $blnSkipGeneral;

		return parent::generate();
	}

	protected function compile() {
		$this->Template->messages = StatusMessage::getAll($this->intModuleId, $this->blnSkipGeneral);

        $GLOBALS['TL_JAVASCRIPT']['huh_statusmessages'] = 'bundles/heimrichhannotstatusmessages/assets/js/status_messages.js|static';
	}
}
