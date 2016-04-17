<?php 

require 'classes/deck.php';
require 'classes/player.php';
require 'classes/holdem.php';

$community_card_1 = new card('Spades','KING');
$community_card_2 = new card('Spades',6);
$community_card_3 = new card('Diamonds',6);
$community_card_4 = new card('Spades',10);
$community_card_5 = new card('Diamonds','QUEEN');

$community_cards_array = array($community_card_1,$community_card_2,$community_card_3, $community_card_4, $community_card_5 );

$player_card_1 = new card('Clubs','JACK');
$player_card_2 = new card('Spades',9);


$test_player = new player('Test Player');
$test_player->set_community($community_cards_array);

$test_player->add_multiple_cards(array($player_card_1,$player_card_2));

$test_player->init_combined_hand();


echo "check flush rst = " . var_export($test_player->check_flush(), true)."\n";

echo $test_player->display_cards();



$community_card_1 = new card('Spades','KING');
$community_card_2 = new card('Spades',6);
$community_card_3 = new card('Diamonds',6);
$community_card_4 = new card('Spades',10);
$community_card_5 = new card('Diamonds','QUEEN');

$community_cards_array = array($community_card_1,$community_card_2,$community_card_3, $community_card_4, $community_card_5 );

$player_card_1 = new card('Spades',3);
$player_card_2 = new card('Spades',9);


$test_player = new player('Test Player');
$test_player->set_community($community_cards_array);


$test_player->add_multiple_cards(array($player_card_1,$player_card_2));

$test_player->init_combined_hand();


echo "check flush rst = " . var_export($test_player->check_flush(), true)."\n";

echo $test_player->display_cards();
