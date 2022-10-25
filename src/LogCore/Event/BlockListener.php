<?php

namespace LogCore\Event;

use JsonException;
use LogCore\Utils\Utils;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockBurnEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

class BlockListener implements Listener
{

    /**
     * @param BlockBreakEvent $event
     * @return void
     * @throws JsonException
     */
    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock()->getName();
        $x = $event->getBlock()->getPosition()->getX();
        $y = $event->getBlock()->getPosition()->getY();
        $z = $event->getBlock()->getPosition()->getZ();
        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['break']['bool']){
            $log = Utils::getLogBlock();
            $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}', '{block}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z, $block], $configuration['events']['break']['text']);

            $log->set($x . "-" . $y . "-" . $z . "_" . $block, $text);
            $log->save();
        }
    }

    /**
     * @param BlockPlaceEvent $event
     * @return void
     * @throws JsonException
     */
    public function onPlace(BlockPlaceEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock()->getName();
        $x = $event->getBlock()->getPosition()->getX();
        $y = $event->getBlock()->getPosition()->getY();
        $z = $event->getBlock()->getPosition()->getZ();
        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['place']['bool']){
            $log = Utils::getLogBlock();
            $text = str_replace(['{player}', '{date}', '{x}', '{y}', '{z}', '{block}'], [$player->getName(), date("d/M/Y H:i:s"), $x, $y, $z, $block], $configuration['events']['place']['text']);

            $log->set($x . "-" . $y . "-" . $z . $block, $text);
            $log->save();
        }
    }

    /**
     * @param BlockBurnEvent $event
     * @return void
     * @throws JsonException
     */
    public function onBurn(BlockBurnEvent $event): void
    {
        $block = $event->getBlock()->getName();
        $x = $event->getBlock()->getPosition()->getX();
        $y = $event->getBlock()->getPosition()->getY();
        $z = $event->getBlock()->getPosition()->getZ();
        $configuration = Utils::getLogConfiguration()->getAll();

        if ($configuration['events']['burn']['bool']){
            $log = Utils::getLogBlock();
            $text = str_replace(['{date}', '{x}', '{y}', '{z}', '{block}'], [date("d/M/Y H:i:s"), $x, $y, $z, $block], $configuration['events']['burn']['text']);

            $log->set($x . "-" . $y . "-" . $z . $block, $text);
            $log->save();
        }
    }
}