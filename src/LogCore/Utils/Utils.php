<?php

namespace LogCore\Utils;

use LogCore\Core;
use pocketmine\utils\Config;

class Utils{

    /**
     * @return string
     */
    public static function getPrefix(): string
    {
        return "§l[§3LogCore§r§l]§r ";
    }

    /**
     * @param array $setting
     * @return Config
     */
    public static function getLogConfiguration(array $setting = []): Config{
        return new Config(Core::getInstance()->getDataFolder() . "configuration.yml", Config::YAML, $setting);
    }

    /**
     * @param array $setting
     * @return Config
     */
    public static function getLog(array $setting = []): Config{
        return new Config(Core::getInstance()->getDataFolder() . "log.yml", Config::YAML, $setting);
    }

    /**
     * @param array $setting
     * @return Config
     */
    public static function getLogBlock(array $setting = []): Config{
        return new Config(Core::getInstance()->getDataFolder() . "logblock.yml", Config::YAML, $setting);
    }

    public static function removeAllLog(): void
    {
        if (!file_exists(Core::getInstance()->getDataFolder() . "log.yml")){
            Core::getInstance()->saveResource("log.yml");
            unlink("log.yml");

        }
    }

}
