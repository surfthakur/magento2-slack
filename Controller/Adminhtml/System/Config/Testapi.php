<?php
namespace Surfarazthakur\Slack\Controller\Adminhtml\System\Config;

use \Magento\Backend\App\Action;
use \Magento\Framework\Controller\Result\JsonFactory;

class Testapi extends Action
{
	protected $_utils;
	protected $_jsonFactory;

	/**
	 * Testapi constructor.
	 * @param Action\Context                     $context
	 * @param \Surfarazthakur\Slack\Helper\Utils $utils
	 * @param JsonFactory                        $jsonFactory
	 */
	public function __construct(
		Action\Context $context,
		\Surfarazthakur\Slack\Helper\Utils $utils,
		JsonFactory $jsonFactory
	){
		parent::__construct($context);
		$this->_utils = $utils;
		$this->_jsonFactory = $jsonFactory;
	}

	/**
	 * @return $this
	 */
	public function execute()
	{
		$text = ["text" => "Magento test \n seems to work \n Congratulations :thumbsup:"];
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

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Surfarazthakur_Slack::testapi');
	}
}