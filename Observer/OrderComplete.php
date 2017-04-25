<?php

namespace Surfarazthakur\Slack\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Sales\Model\Order;
use \Magento\Catalog\Api\ProductRepositoryInterfaceFactory;
use \Magento\Framework\Event\Observer;
use \Surfarazthakur\Slack\Helper\Utils;

class OrderComplete implements ObserverInterface
{
	/**
	 * @var LoggerInterface
	 */
	protected $_loggerInterface;
	/**
	 * @var string
	 */
	protected $_logDir = 'slack';
	/**
	 * @var Order
	 */
	protected $_order;
	/**
	 * @var Utils
	 */
	protected $_helper;
	/**
	 * @var ProductRepositoryInterfaceFactory
	 */
	protected $_productRepositoryInterfaceFactory;

	/**
	 * OrderComplete constructor.
	 * @param LoggerInterface                   $loggerInterface
	 * @param Order                             $order
	 * @param Utils                             $helper
	 * @param ProductRepositoryInterfaceFactory $productRepositoryInterfaceFactory
	 */
	public function __construct(
		LoggerInterface $loggerInterface,
		Order $order,
		Utils $helper,
		ProductRepositoryInterfaceFactory $productRepositoryInterfaceFactory
	){
		$this->_loggerInterface = $loggerInterface;
		$this->_order = $order;
		$this->_helper = $helper;
		$this->_productRepositoryInterfaceFactory = $productRepositoryInterfaceFactory;
	}

	/**
	 * @param Observer $observer
	 */
	public function execute(Observer $observer)
	{
		if ($this->_helper->getModuleStatus()) {

			$order_ids = $observer->getDataByKey('order_ids');

			$order_items = [];
			$data = [];
			foreach ($order_ids as $order_id) {
				$order = $this->_order->loadByIncrementId((int)$order_id);
				foreach ($order->getAllItems() as $item) {

					$prod = $this->_productRepositoryInterfaceFactory->create()->getById($item->getItemId());

					$order_items[] = [
						'sku'     => $item->getSku(),
						'item_id' => $item->getItemId(),
						'price'   => $item->getPrice(),
						'image'   => $prod->getData('image'),
						'test1'   => $prod->getData('test_attribute'),
						'test2'   => $prod->getData('test_attribute_status'),
					];
				}
			}


			if (count($order_items > 0)) {

				$text = "";
				$url = $this->_helper->getUrl();
				$text .= $this->_helper->getBeforeMessage();

				foreach ($order_items as $it) {
					$text .= $it['sku'] . " for " . $it['price'] . " \n ";
					$text .= $it['image'] . "\n";
					$text .= $it['test1'] . "\n";
					$text .= $it['test2'] . "\n";
				}

				$text .= $this->_helper->getAfterMessage();

				$data['text'] = $text;

				$this->_helper->curl($url, $data);
			}
		}
	}
}