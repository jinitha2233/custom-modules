<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Bigeyedeers\SkuNotifications\Model\SkuNotifications::class,
            \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications::class
        );
    }
}

