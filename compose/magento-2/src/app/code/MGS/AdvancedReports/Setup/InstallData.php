<?php

namespace MGS\AdvancedReports\Setup;

use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 0]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 1]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 2]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 3]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 4]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 5]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 6]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 7]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 8]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 9]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 10]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 11]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 12]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 13]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 14]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 15]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 16]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 17]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 18]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 19]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 20]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 21]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 22]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_hour'),
            ['h' => 23]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 1]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 2]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 3]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 4]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 5]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 6]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('mgs_advancedreports_dayofweek'),
            ['dow' => 7]
        );
        $setup->endSetup();
    }
}
