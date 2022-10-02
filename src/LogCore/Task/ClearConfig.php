<?php

namespace LogCore\Task;

use LogCore\Core;
use LogCore\Utils\Utils;
use pocketmine\scheduler\Task;

class ClearConfig extends Task
{

    /**
     * @inheritDoc
     */
    public function onRun(): void
    {
        $log = Utils::getLog();

        if (Core::$timer == 3456000)
        {
            Core::getInstance()->getLogger()->warning("Reset log in 2 days !");
        } elseif (Core::$timer == 1728000)
        {
            Core::getInstance()->getLogger()->warning("Reset log in 2 days !");
        }elseif (Core::$timer == 0){
            Core::getInstance()->getLogger()->warning("Reset log !");


        }

        Core::$timer--;
    }
}