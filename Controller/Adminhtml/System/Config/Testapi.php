<?php
namespace Surfarazthakur\Slack\Controller\Adminhtml\System\Config;

use \Magento\Backend\App\Action;
use \Magento\Framework\Controller\Result\JsonFactory;

class Testapi extends Action
{
	protected $_utils;
	protected $_jsonFactory;

	public function __construct(
		Action\Context $context,
		\Surfarazthakur\Slack\Helper\Utils $utils,
		JsonFactory $jsonFactory
	){
		parent::__construct($context);
		$this->_utils = $utils;
		$this->_jsonFactory = $jsonFactory;
	}

	public function execute()
	{
		$text = ["text" => "@here Magento test \n seems to work \n Congratulations :innocent:"];
		$result = $this->_jsonFactory->create();
		$this->_utils->curl($this->_utils->getUrl(), $text);

		return $result->setData(
			[
				'success'    => true,
				'url'        => $this->_utils->getUrl(),
				'text sent ' => $text,
			]
		);
	}

	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Surfarazthakur_Slack::testapi');
	}
}