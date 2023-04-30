<?php

namespace LogCore\command;

use LogCore\Utils\Permission;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\Server;

class LogStickCommand extends Command
{
    public function __construct(){
		parent::__construct("logstick");
		$this->setPermission("logstick.command");
		$this->setUsage("/logstick");
	}
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player)
        {
            if ($sender->hasPermission(Permission::SITCKLOG))
            {
                $stick = VanillaItems::STICK();
                $stick->setCustomName("§rLog Stick");
                $stick->setCount(1);

                foreach (Server::getInstance()->getOnlinePlayers() as $player)
                {
                    if ($player->hasPermission(DefaultPermissions::ROOT_OPERATOR))
                    {
                        $player->sendMessage("$sender s'est give un stick de log !");
                    }
                }
                $sender->sendMessage("Vous vous êtes give un stick de log !");
                $sender->getInventory()->addItem($stick);
            }
        }
    }
}
