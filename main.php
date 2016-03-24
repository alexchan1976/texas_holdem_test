<?php

require 'classes/deck.php';
require 'classes/player.php';
require 'classes/holdem.php';

$playing_deck = new deck();

echo "welcome Texas hold'em\n";
$try = 0 ;
do {
	if($try > 0)
	{
		echo "invalid numeric input!\n";
	}
	$number_of_players = readline("how many players? ");
	$try++;
}
while(is_numeric($number_of_players) == false);

$players = array();


for($i = 0 ; $i < $number_of_players ; $i++)
{
	$tmp = $i+1;
	$name = "Player $tmp"; 
	$player = new player($name);
	$player->add_multiple_cards($playing_deck->deal_multi_cards(2));
	$players[] = $player;
}


$holdem = new holdem_game($playing_deck, $players);

$winner = $holdem->player_high_hand();

echo $winner ." is winner!\n";
echo "winning hand\n";
$holdem->get_player_hand($name);
echo "\nall hands\n\n";
$holdem->get_all_hands();