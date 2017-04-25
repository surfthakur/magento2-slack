<?php
namespace Surfarazthakur\Slack\Block\System\Config;

use \Magento\Framework\Data\Form\Element\AbstractElement;

class Testapi extends \Magento\Config\Block\System\Config\Form\Field
{
	protected $_template = 'Surfarazthakur_Slack::system/config/test.phtml';

	public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
	{
		$element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

		return parent::render($element);
	}

	protected function _getElementHtml(AbstractElement $element)
	{
		return $this->_toHtml();
	}

	public function getAjaxUrl()
	{
		return $this->getUrl('slack/system_config/testapi');
	}

	public function getButtonHtml()
	{
		$button = $this->getLayout()->createBlock(
			'Magento\Backend\Block\Widget\Button'
		)->setData(
			[
				'id'    => 'testapi_button',
				'label' => __('TEST api'),
			]
		);

		return $button->toHtml();
	}
}