<?php

namespace HeimrichHannot\StatusMessages\FrontendModule;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\System;
use HeimrichHannot\StatusMessages\Asset\FrontendAsset;
use HeimrichHannot\StatusMessages\StatusMessage;

class StatusMessagesModule extends Module
{

	protected $strTemplate = 'mod_status_messages';
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
	    $messages = StatusMessage::getAll($this->intModuleId, $this->blnSkipGeneral);
	    if (!empty($messages)) {
            $this->Template->messagesRaw = $messages;
            $formatted = '';
            foreach ($messages as $message) {
                $formatted .= $message->formatted ?: $message->text;
            }
            $this->Template->messages = $formatted;
        }

	    System::getContainer()->get(FrontendAsset::class)->addFrontendAssets();
	}
}
