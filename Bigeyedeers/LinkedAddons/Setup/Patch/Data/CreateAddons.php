<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\LinkedAddons\Setup\Patch\Data;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateAddons implements DataPatchInterface
{
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;

        $data = [
            [
                'link_type_id' => \Bigeyedeers\LinkedAddons\Model\Product\Link::LINK_TYPE_ADDONS,
                'code' => 'addons'
            ],
        ];

        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('catalog_product_link_type'), $bind);
        }
        $data = [
            [
                'link_type_id' => \Bigeyedeers\LinkedAddons\Model\Product\Link::LINK_TYPE_ADDONS,
                'product_link_attribute_code' => 'position',
                'data_type' => 'int',
            ]
        ];
        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
