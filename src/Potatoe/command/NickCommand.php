<?php

declare(strict_types=1);

namespace Potatoe\command;

use Potatoe\Core;

use pocketmine\command\CommandSender;
use pocketmine\Player;

class NickCommand extends BaseCommand{

    /** @var array $nick */
    public $nick = [];
    /** @var Core $plugin */
    private $plugin;

    public function __construct(Core $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin, "nick", "Nick Yourself", "/nick", ["nick"]);
    }

    public function execute(CommandSender $sender, $commandLabel, array $args) : bool{
        if($sender instanceof Player){
            if($sender->hasPermission("core.all") || !$sender->hasPermission("core.cmd.all") || !$sender->hasPermission("core.cmd.nick")){
                if(!isset($args[0])){
                    $sender->sendMessage("§9§lNick>§r§7 Use /nick [name]");
                }else{
                    if($args[0] == "off"){
                        $this->unNick($sender);
                        $sender->sendMessage("§9§lNick>§r§7 You Are No Longer Nicked");
                    }else{
                        $this->nick($sender, $args[0]);
                        $sender->sendMessage("§9§lNick>§r§7 You Now Nicked As " . $args[0]);
                    }
                }
            }else{
                $sender->sendMessage(Core::PERM_RANK);
                return false;
            }
        }else{
            $sender->sendMessage(Core::USE_IN_GAME);
            return false;
        }
        return true;
    }

    public function nick(Player $player, $nick) : void{
        if($player instanceof Player){
            $player->setDisplayName($nick);
        }
    }

    public function unNick(Player $player) : void{
        if($player instanceof Player){
            $player->setDisplayName($player->getName());
        }
    }
}
