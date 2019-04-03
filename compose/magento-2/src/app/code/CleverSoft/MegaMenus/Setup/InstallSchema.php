<?php
/**
 * @category    CleverSoft
 * @package     CleverMegaMenus
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\MegaMenus\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface {
    
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){
		$installer = $setup;
        $installer->startSetup();
		$table = $installer->getConnection()->newTable($installer->getTable('clever_megamenu'))->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'Menu ID'
        )->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Identifier'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Title'
        )->addColumn(
            'type',
             \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0'],
            'Type'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            [],
            'Content'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Menu Active'
        )->addColumn(
            'style',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Menu Style'
        )->addIndex(
            $installer->getIdxName('clever_megamenu', ['identifier']),
            ['identifier']
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('clever_megamenu'),
                ['title'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'CleverSoft Mega Menus Table'
        );
		$installer->getConnection()->createTable($table);
	}
}
