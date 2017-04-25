<?php
namespace Surfarazthakur\Slack\Controller\Adminhtml\Api;

use \Magento\Framework\View\Result\PageFactory;
use \Psr\Log\LoggerInterface;
use \Surfarazthakur\Slack\Helper\Utils;

class Develop extends \Magento\Backend\App\Action
{
	protected $_resultPageFactory;
	protected $_loggerInterface;
	protected $_logDir = 'slack';
	protected $_utils;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		PageFactory $resultPageFactory,
		LoggerInterface $loggerInterface,
		Utils $utils
	){
		parent::__construct($context);

		$this->_resultPageFactory = $resultPageFactory;
		$this->_loggerInterface = $loggerInterface;
		$this->_utils = $utils;
	}

	public function execute()
	{
		$test = [
			'text' => 'hello from the otherside w',
		];
		$url = $this->_utils->getUrl();
		$status = $this->_utils->getModuleStatus();
		$beforeMessage = $this->_utils->getBeforeMessage();
		$afterMessage = $this->_utils->getAfterMessage();
		$orderComplete = $this->_utils->getCustomerOrderComplete();
		$signup = $this->_utils->getCustomerSignup();
		$orderItems = $this->_utils->getOrderItems();

		var_dump(
			[
				__METHOD__ => $url,
				$status,
				$beforeMessage,
				$afterMessage,
				$orderComplete,
				$signup,
				$orderItems,
				"file"     => __FILE__,
				"line"     => __LINE__,
			]
		);
die();
		$page = $this->_resultPageFactory->create();

		$page->setActiveMenu('Surfarazthakur_Slack::develop');

		return $page;
	}

	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Surfarazthakur_Slack::develop');
	}
}
