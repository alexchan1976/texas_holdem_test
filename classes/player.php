<?php 
class player
{
	private $hand = array();
	private $name = '';
	private $community = array();
	private $combined_hand = array();
	private $matches = array();
	private $winning_hand = array();
	private $score = 0 ;
	private $win_string = '';

	public function __construct($name)
	{
		$this->hand = array();
		$this->name = $name; 
	}
	public function get_name()
	{
		return $this->name;
	}

	public function set_community(array $community)
	{
		$this->community = $community;
	}
	public function add_one_card_to_hand(card $card)
	{
		$this->hand[] = $card;
	}
	public function add_multiple_cards(array $cards)
	{
		if(is_array($cards) == true)
		{
			$this->hand = $cards;	
		}
	}
	public function get_hand()
	{
		return $this->hand;
	}
	public function check_flush()
	{
		$cards_in_suits = array();
		foreach ($this->combined_hand as $card) {
			$cards_in_suits[$card->get_suite()][] = $card;
		}

		foreach ($cards_in_suits as $suit => $cards) {
			if(count($cards) == 5)
			{
				$this->win_string = 'Flush';
				$this->winning_hand = $cards;
				return true;
			}
		}
		return false;
	}
	/**
	 * @param array cards
	 */
	public function check_match()
	{
		$temp_card_array = array();//sort cards in array
		$matched_cards = array();
		foreach($this->combined_hand as $card)
		{
			$temp_card_array[$card->get_abs_value()][] = $card;
		}
		foreach ($temp_card_array as $key => $value) 
		{
			if(count($value) > 1)
			{
				$matched_cards[$key] = $value;
			}
		}
		$this->matches = $matched_cards;
		krsort($this->matches);
	}
	public function amount_of_pairs()
	{
		$count_pairs = 0;
		foreach ($this->matches as $abs_value => $cards)
		{
			if(count($cards) == 2)
			{
				$count_pairs +=1;
			}
		}
		return $count_pairs;
	}

	public function check_full_house()
	{
		$matches = $this->check_match();
		if($this->amount_of_pairs() >= 1 && $this->check_three_of_kind() == true)
		{
			return true;
		}
	}
	public function check_three_of_kind()
	{
		foreach ($this->matches as $abs_value => $cards) {
			if(count($cards) == 3)
			{
				return true;
			}
		}
		return false;
	}
	
	public function check_four()
	{
		
		foreach($this->matches as $key => $value)
		{
			if(count($value) == 4)
			{
				return true;
			}
		}
		return false;
	}
	public function check_straight()
	{
		$abs_array=$this->get_abs_sort();
		$off_by_one_count = 0;
		$temp_hand = array();
		for( $i=0; $i< count($abs_array) ; $i++)
		{
			$next = $i+1;
			$diff = $abs_array[$next]->get_abs_value - $abs_array[$i]->get_abs_value() ;
			if($dff == 1)
			{
				$off_by_one_count += 1;
				$temp_hand[] = $abs_array[$i];
			}
		}
		if($off_by_one_count > 4 && count($temp_hand) >= 5)
		{
			$this->winning_hand = $temp_hand;
			$this->win_string = 'STRAIGHT';
			return true;
		}
		return false;
	}
	private function get_abs_sort()
	{
		$abs_array = array();
		if($abs_array < 5){
			return false;
		}
		foreach($this->combined_hand as $card)
		{
			$abs_array[] = $card->get_abs_value();
			if($card->get_abs_value()==14)
			{
				$abs_array[]=1;
			}
		}
		$abs_array =array_unique($abs_array);
		sort($abs_array);
		return $abs_array;
	}
	public function check_straight_flush()
	{
		if(($this->check_straight() == true )&& ($this->check_flush() == true))
		{
			return true;
		}
		return false;
	}
	public function check_royal_flush()
	{
		$abs_array = $this->get_abs_sort();
		if((end($abs_array) == 14) && $this->check_straight_flush($community))
		{
			return true;
		}
		return false;
	}
	public function init_combined_hand()
	{
		$this->combined_hand = array_merge($this->hand, $this->community);
	}
	public function get_high_hand(array $community)
	{
		$this->set_community($community);
		
		if($this->check_royal_flush() == true)
		{
			$this->score =  1000;
		}
		if($this->check_straight_flush() == true)
		{
			$this->score = 9999;
		}
		if($this->check_four() == true)
		{
			$this->score = 9800;
		}
		if($this->check_full_house() == true)
		{
			$this->score = 97;
		}
		if($this->check_straight() == true)
		{
			$this->score = 96 ;
		}

		$abs_array=$this->get_abs_sort();
		$this->score =  end($abs_array);
	}
	public function display_cards()
	{
		foreach($this->winning_hand as $card)
		{
			echo $card."\n";
		}
	}
}