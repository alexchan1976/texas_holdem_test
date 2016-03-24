<?php

class holdem_game {
	
	private $community_cards = array();
	private $players = array();
	private $deck;
	public function __construct($deck, $players)
	{
		$this->deck = $deck;
		$this->players = $players;
		$this->init_community_cards();
	}
	private function init_community_cards()
	{
		$this->community_cards = $this->deck->deal_multi_cards(5);
	}

	public function get_community_cards()
	{
		return $this->community_cards;
	}
	public function player_high_hand()
	{
		$player_scores = array();
		foreach($this->players as $player)
		{
			$val = $player->get_high_hand($this->community_cards);
			$player_scores[$player->get_name()] = $val;
		}
		arsort($player_scores);
		$i = 0 ;
		foreach($player_scores as $key => $val)
		{
			if($i==0)
			{
				return $key;
			}
		}
	}
	public function get_player_hand($name)
	{
		foreach($this->players as $player)
		{
			//echo "\ndebug" .$player->getName()."\n";
			if($player->get_name() == $name)
			{
				echo $player->display_cards();
				echo $this->display_community();
			}
		}
	}
	public function get_all_hands()
	{
		foreach($this->players as $player)
		{
			echo "\nplayer name" .$player->get_name()."\n";

				echo $player->display_cards();
				echo $this->display_community();
				echo "\n-------\n";
		}
	}
	public function display_community()
	{
		foreach($this->community_cards as $card)
		{
			echo $card."\n";
		}
	}
}