<?php
require_once('card.php');
class deck
{

	private $suite = array("Diamonds","Clubs", "Hearts", "Spades");

	private $values = array(2,3,4,5,6,7,8,9,10,"JACK","QUEEN","KING","ACE");

	private $card_deck = array();

	public function __construct()
	{
		$this->init_deck();
		shuffle($this->card_deck);
	}

	private function init_deck()
	{
		$this->card_deck = array();
		foreach($this->suite as $suite)
		{
			foreach($this->values as $val)
			{
				$this->card_deck[] = new card($suite, $val);
			}
		}
	}

	public function get_card_deck()
	{
		return $this->card_deck;
	}

	public function deal_card()
	{
		$cards = array_pop($this->card_deck);
		return $cards;
	}

	public function deal_multi_cards($num)
	{
		$dealt_cards = array();
		if ($num <0 ){
			return $dealt_cards;
		}
		if($num <= count($this->card_deck))
		{
			for($i = 0; $i< $num; $i++)
			{
				$dealt_cards[] = $this->deal_card();
			}
			return $dealt_cards;
		}
	}
}