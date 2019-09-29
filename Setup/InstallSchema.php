<?php

namespace Magejar\OrderFeedback\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Custom order column
     */
    const ORDER_FEEDBACK_FIELD = 'cone_customer_feedback';
	const ORDER_POSFLAG_FIELD = 'cone_custom_id';
	

    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            self::ORDER_FEEDBACK_FIELD,
            [
                'type' => Table::TYPE_TEXT,
                'size' => 255,
                'nullable' => true,
                'comment' => 'Customer Feedback'
            ]
        );
		$setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            self::ORDER_POSFLAG_FIELD,
            [
                'type' => Table::TYPE_TEXT,
                'size' => 255,
                'nullable' => true,
                'comment' => 'POS Flag '
            ]
        );
        $setup->endSetup();
    }
}