<?php
namespace Surfarazthakur\Slack\Helper;

use \Psr\Log\LoggerInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;


class Utils
{
	protected $_loggerInterface;
	protected $_scopeConfigInteface;

	/**
	 * Utils constructor.
	 * @param LoggerInterface      $loggerInterface
	 * @param ScopeConfigInterface $scopeConfigInterface
	 */
	public function __construct(LoggerInterface $loggerInterface, ScopeConfigInterface $scopeConfigInterface)
	{
		$this->_loggerInterface = $loggerInterface;
		$this->_scopeConfigInteface = $scopeConfigInterface;
	}

	/**
	 * @return int
	 */
	public function getModuleStatus()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/enable',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return string | null
	 */
	public function getUrl()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/display_text',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return string | null
	 */
	public function getBeforeMessage()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/before_message',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return string | null
	 */
	public function getAfterMessage()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/after_message',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return int
	 */
	public function getCustomerSignup()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/customer_signup',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return int
	 */
	public function getCustomerOrderComplete()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/customer_order_complete',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @return int
	 */
	public function getOrderItems()
	{
		return $this->_scopeConfigInteface->getValue(
			'slack/general/order_items',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * @param        $url
	 * @param array  $params
	 * @param string $method
	 * @param array  $header
	 * @return mixed|null
	 */
	public function curl($url, $params = [], $method = "POST", $header = [])
	{
		try {
			curl_init();
			$data = $params;
			$data_string = json_encode($data);

			$headers = [
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string),
			];
			$headers = array_merge($headers, $header);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result);


			return $result;
		} catch (\Exception $e) {

			$this->_loggerInterface->error(
				'curl_error',
				[
					"Error"  => $e->getMessage(),
					"LINE"   => __LINE__,
					"METHOD" => __METHOD__,
				],
				$this->_logDir
			);

			return null;
		}
	}
}