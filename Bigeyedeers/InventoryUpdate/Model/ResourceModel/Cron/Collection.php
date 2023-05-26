<?php 
/**
 * Copyright © Bigeyedeers. All rights reserved.
 * See COPYING.txt for license details.
*/
namespace Bigeyedeers\InventoryUpdate\Model\ResourceModel\Cron;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection { 
   
   /**
     * @var string
   */
   protected $_idFieldName = 'schedule_id';

   public function _construct() { 
      $this->_init(\Magento\Cron\Model\Schedule::class,
      \Magento\Cron\Model\ResourceModel\Schedule::class);
   }
 } 