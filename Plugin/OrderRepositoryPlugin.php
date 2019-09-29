<?php
/* File: app/code/Magejar/OrderFeedback/Plugin/OrderRepositoryPlugin.php */

namespace Magejar\OrderFeedback\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderRepositoryPlugin
 */
class OrderRepositoryPlugin
{
    /**
     * Order feedback field name
     */
    const FIELD_NAME_FEEDBACK = 'cone_customer_feedback';
	const FIELD_NAME_POSFLAG = 'cone_custom_id';

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Add "cone_customerFeedback" and "cone_custom_id" extension attributes to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $customerFeedback = $order->getData(self::FIELD_NAME_FEEDBACK);
		$cone_custom_id  = $order->getData(self::FIELD_NAME_POSFLAG);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setConeCustomerFeedback($customerFeedback);
		$extensionAttributes->setConeCustomId($cone_custom_id);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * Add "cone_customerFeedback" and "cone_custom_id" extension attributes to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            $customerFeedback = $order->getData(self::FIELD_NAME_FEEDBACK);
			$cone_custom_id  = $order->getData(self::FIELD_NAME_POSFLAG);
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setConeCustomerFeedback($customerFeedback);
			$extensionAttributes->setConeCustomId($cone_custom_id);
            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}