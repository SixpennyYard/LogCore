<?php

namespace LogCore;

use JsonException;
use LogCore\Event\BlockListener;
use LogCore\Event\PlayerListener;
use LogCore\Task\ClearConfig;
use LogCore\Utils\Permission;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Core extends PluginBase
{

    const CONFIGURATION = [
        "events" => [
            "join" => [
                "bool" => "true",
                "text" => "[{date}] {player} join"
            ],
            "kick" => [
                "bool" => "true",
                "text" => "[{date}] {player} kick. reason: {reason}"
            ],
            "quit" => [
                "bool" => "true",
                "text" => "[{date}] {player} quit"
            ],
            "death" => [
                "bool" => "true",
                "text" => "[{date}] {player} death"
            ],
            "chat" => [
                "bool" => "true",
                "text" => "[{date}] {player} chat"
            ],
            "break" => [
                "bool" => "true",
                "text" => "[{date}] {player} break at {x}, {y}, {z}. block: {block}"
            ],
            "place" => [
                "bool" => "true",
                "text" => "[{date}] {player} break at {x}, {y}, {z}. block: {block}"
            ],
            "burn" => [
                "bool" => "true",
                "text" => "[{date}] {block} burn at {x}, {y}, {z}."
            ],
        ],

    ];

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
     * @throws JsonException
     */
    protected function onEnable(): void
    {
        self::$instance = $this;

        $this->registerPermission();

        $this->getServer()->getPluginManager()->registerEvents(new BlockListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);
        $this->getScheduler()->scheduleRepeatingTask(new ClearConfig(), 20);
        $this->getServer()->getCommandMap()->register("LogStick", new command\LogStickCommand());

        $this->getLogger()->info("Plugin LogCore is Enabled !");

        $config = new Config($this->getDataFolder() . "configuration.yml", Config::YAML);
        $config->setAll(self::CONFIGURATION);
        $config->save();
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