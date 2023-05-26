<?php
/**
 * Copyright © Bigeyedeers. All rights reserved.
 * See COPYING.txt for license details.
*/

namespace Bigeyedeers\InventoryUpdate\Logger;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger;

class Handler extends BaseHandler
{
   /**
    * Logging level
    * @var int
    */
   protected $loggerType = Logger::DEBUG;

   /**
    * File name
    * @var string
    */
   protected $fileName = '/var/log/inventory_logger.log';
}