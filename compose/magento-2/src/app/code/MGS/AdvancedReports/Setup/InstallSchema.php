<?php

namespace MGS\AdvancedReports\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('mgs_advancedreports_hour'))
            ->addColumn(
                'h',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Hour'
            )
            ->setComment('Hour');
        $installer->getConnection()->createTable($table);
        $table = $installer->getConnection()
            ->newTable($installer->getTable('mgs_advancedreports_dayofweek'))
            ->addColumn(
                'dow',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Day Of Week'
            )
            ->setComment('Day Of Week');
        $installer->getConnection()->createTable($table);
        $table = $installer->getConnection()
            ->newTable($installer->getTable('mgs_advancedreports_newandreturning'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'period',
                Table::TYPE_TEXT,
                250,
                [],
                'Period'
            )
            ->addColumn(
                'new_customers',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => '0'],
                'New Customers'
            )
            ->addColumn(
                'returning_customers',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => '0'],
                'Returning Customers'
            )
            ->addColumn(
                'percentage_of_new_customers',
                Table::TYPE_TEXT,
                250,
                ['default' => null],
                'Percentage Of New Customers'
            )
            ->addColumn(
                'percentage_of_returning_customers',
                Table::TYPE_TEXT,
                250,
                ['default' => null],
                'Percentage Of Returning Customers'
            )
            ->setComment('New And Returning Customers');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
