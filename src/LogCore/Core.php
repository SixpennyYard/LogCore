<?php

namespace LogCore;

use LogCore\Event\BlockListener;
use LogCore\Event\PlayerListener;
use LogCore\Task\ClearConfig;
use LogCore\Utils\Permission;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;

class Core extends PluginBase
{

    /**
     * @var int
     */
    public static int $timer = 12096000;

    /**
     * @var Core
     */
    public static Core $instance;


    /**
     * @return Core
     */
    public static function getInstance(): Core{
        return self::$instance;
    }

    /**
     * @return void
     */
    protected function onEnable(): void
    {
        self::$instance = $this;

        $this->registerPermission();

        $this->getServer()->getPluginManager()->registerEvents(new BlockListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);
        $this->getScheduler()->scheduleRepeatingTask(new ClearConfig(), 20);

        $this->getLogger()->info("Plugin LogCore is Enabled !");
    }

    /**
     * @return void
     */
    private function registerPermission(): void
    {
        $class = new \ReflectionClass(Permission::class);

        $mgr = PermissionManager::getInstance();
        $rootOp = $mgr->getPermission(DefaultPermissions::ROOT_OPERATOR);

        foreach ($class->getConstants() as $constant => $permission) {
            DefaultPermissions::registerPermission(new \pocketmine\permission\Permission($permission, $permission), [$rootOp]);
        }
    }

}