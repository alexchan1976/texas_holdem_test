<?php 

require 'classes/deck.php';
require 'classes/player.php';
require 'classes/holdem.php';

$community_card_1 = new card('Hearts',2);
$community_card_2 = new card('Clubs',6);
$community_card_3 = new card('Diamonds',6);
$community_card_4 = new card('Spades',10);
$community_card_5 = new card('Clubs','QUEEN');

$community_cards_array = array($community_card_1,$community_card_2,$community_card_3, $community_card_4, $community_card_5 );

$player_card_1 = new card('Clubs','KING');
$player_card_2 = new card('Diamonds',9);

$test_player = new player('Test Player');

$test_player->add_multiple_cards(array($player_card_1,$player_card_2));

$matched_cards_array = $test_player->check_match($community_cards_array);

print_r($matched_cards_array);
