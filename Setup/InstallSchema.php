<?php
namespace AHT\ProductFee\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'total_fee',
            [
                'type' => 'int',
                'nullable' => 'true',
                'default' => 0,
                'comment' => 'Total Fee'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'total_fee',
            [
                'type' => 'int',
                'nullable' => 'true',
                'default' => 0,
                'comment' => 'Total Fee'
            ]
        );

        $setup->endSetup();
    }
}