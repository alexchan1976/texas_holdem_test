<?php 

require 'classes/deck.php';
require 'classes/player.php';
require 'classes/holdem.php';

$community_card_1 = new card('Hearts','KING');
$community_card_2 = new card('Clubs',6);
$community_card_3 = new card('Diamonds',6);
$community_card_4 = new card('Spades',10);
$community_card_5 = new card('Clubs','QUEEN');

$community_cards_array = array($community_card_1,$community_card_2,$community_card_3, $community_card_4, $community_card_5 );

$player_card_1 = new card('Clubs','JACK');
$player_card_2 = new card('Diamonds',9);

$test_player = new player('Test Player');
$test_player->set_community($community_cards_array);

$test_player->add_multiple_cards(array($player_card_1,$player_card_2));

$test_player->init_combined_hand();

$test_player->check_match();



echo "has 1 pairs = " . var_export($test_player->amount_of_pairs(), true)."\n";

echo "display winning hand\n";

echo "\n";


$three_of_kind_test = $test_player->check_three_of_kind();

echo  "test 3 of kind = " . var_export($three_of_kind_test,true);
echo "\n";


$community_card_1 = new card('Hearts','KING');
$community_card_2 = new card('Clubs',6);
$community_card_3 = new card('Diamonds',6);
$community_card_4 = new card('Spades','KING');
$community_card_5 = new card('Clubs','QUEEN');
$community_cards_array = array($community_card_1,$community_card_2,$community_card_3, $community_card_4, $community_card_5 );
$test_player->set_community($community_cards_array);
$three_of_kind_test = $test_player->check_three_of_kind($community_cards_array);

echo  "test 3 of kind = " . var_export($three_of_kind_test,true);
echo "\n";
