<?php

namespace LogCore\Event;

use JsonException;
use LogCore\Utils\Permission;
use LogCore\Utils\Utils;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\permission\DefaultPermissions;
use pocketmine\Server;

class PlayerListener implements Listener
{

    /**
     * @param PlayerJoinEvent $event
     * @return void
     * @throws JsonException
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        $x = $event->getPlayer()->getPosition()->getX();
        $y = $event->getPlayer()->getPosition()->getY();
        $z = $event->getPlayer()->getPosition()->getZ();

        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['join']['bool']){
            $log = Utils::getLog();
            $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['join']['text']);
            $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text);
            $log->save();
        }

    }

    /**
     * @param PlayerQuitEvent $event
     * @return void
     * @throws JsonException
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();
        $x = $event->getPlayer()->getPosition()->getX();
        $y = $event->getPlayer()->getPosition()->getY();
        $z = $event->getPlayer()->getPosition()->getZ();

        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['quit']['bool']){
            $log = Utils::getLog();
            $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['quit']['text']);

            $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text);
            $log->save();
        }

    }

    /**
     * @param PlayerChatEvent $event
     * @return void
     * @throws JsonException
     */
    public function onChat(PlayerChatEvent $event): void
    {
        $player = $event->getPlayer();

        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['chat']['bool']){
            $log = Utils::getLog();
            $text = str_replace(['{player}', '{date}'], [$player->getName(), date("d/M/Y H:i:s")], $configuration['events']['chat']['text']);

            $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text);
            $log->save();
        }

    }

    /**
     * @param PlayerDeathEvent $event
     * @return void
     * @throws JsonException
     */
    public function onDeath(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();
        $x = $event->getPlayer()->getPosition()->getX();
        $y = $event->getPlayer()->getPosition()->getY();
        $z = $event->getPlayer()->getPosition()->getZ();
        $cause = $player->getLastDamageCause()->getCause();

        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['death']['bool']){
            if ($cause === EntityDamageEvent::CAUSE_ENTITY_ATTACK){
                $log = Utils::getLog();
                $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['death']['text']);

                $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text . " cause: entity / player");
                $log->save();
            }elseif ($cause === EntityDamageEvent::CAUSE_SUICIDE){
                $log = Utils::getLog();
                $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['death']['text']);

                $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text . " cause: suicide");
                $log->save();
            }elseif ($cause === EntityDamageEvent::CAUSE_MAGIC){
                $log = Utils::getLog();
                $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['death']['text']);

                $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text . " cause: potion");
                $log->save();
            }elseif ($cause === EntityDamageEvent::CAUSE_FIRE){
                $log = Utils::getLog();
                $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['death']['text']);

                $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text . " cause: fire");
                $log->save();
            }elseif ($cause === EntityDamageEvent::CAUSE_LAVA){
                $log = Utils::getLog();
                $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z], $configuration['events']['death']['text']);

                $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text . " cause: lava");
                $log->save();
            }

        }

    }

    /**
     * @param PlayerKickEvent $event
     * @return void
     * @throws JsonException
     */
    public function onKick(PlayerKickEvent $event): void
    {
        $player = $event->getPlayer();
        $x = $event->getPlayer()->getPosition()->getX();
        $y = $event->getPlayer()->getPosition()->getY();
        $z = $event->getPlayer()->getPosition()->getZ();
        $reason = $event->getReason();

        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['kick']['bool']){
            $log = Utils::getLog();
            $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}', '{reason}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z, $reason], $configuration['events']['kill']['text']);

            $log->set($player->getName() . "_" . date("d/M/Y-H:i:s"), $text);
            $log->save();
        }

    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $x = $block->getPosition()->getX();
        $y = $block->getPosition()->getY();
        $z = $block->getPosition()->getZ();

        if ($player->hasPermission(Permission::SITCKLOG))
        {
            $config = Utils::getLogBlock();
            foreach ($config->getAll() as $value)
            {
                if (str_contains($value, "$x-$y-$z")){
                    $player->sendMessage("[Logs] " . $value);
                }
            }
            foreach (Server::getInstance()->getOnlinePlayers() as $players)
            {
                if ($players->hasPermission(DefaultPermissions::ROOT_OPERATOR))
                {
                    $players->sendMessage("$player cherche des logs en $x, $y, $z");
                }
            }
        }
    }
}