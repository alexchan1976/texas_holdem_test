<?php 
class player
{
	private $hand = array();
	private $name = '';

	public function __construct($name)
	{
		$this->hand = array();
		$this->name = $name; 
	}
	public function get_name()
	{
		return $this->name;
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
	public function check_flush($community)
	{
		for($i=1 ; $i < count($this->hand) ; $i++)
		{
			if(($this->hand[$i]->get_suite() != $this->hand[$i-1]->get_suite() ))
			{
				return false;
			}
		}
		$suite_in_hand = $this->hand[$i-1]->get_suite();
		for($i=1; $i < count($community) ; $i++){
			if($community[$i]->get_suite() != $suite_in_hand)
			{
				return false;
			}
			if(($community[$i]->get_suite() != $community[$i-1]->get_suite()))
			{
				return false;
			}
		}
		return true;
	}
	/**
	 * @param array cards
	 */
	public function check_match($community)
	{
		$temp_card_array = array();//sort cards in array
		$combined_hand = array_merge($community , $this->hand);
		$matched_cards = array();
		foreach($combined_hand as $card)
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
		return $matched_cards;
	}
	public function check_2pairs($comm)
	{
		$matches = $this->check_match($comm);
		$number_of_pairs = 0;
		foreach ($matches as $abs_value => $cards) {
			if(count($cards) == 2)
			{
				$number_of_pairs +=1;
			}
		}
		if($number_of_pairs == 2)
		{
			return true;
		}
		else
		{
			return false;	
		}
		
	}
	public function check_has_pairs($community)
	{
		$matches = $this->check_match($community);
		foreach ($matches as $key => $cards) {
			if(count($cards) == 2)
			{
				return true;
			}
		}
		return false;
	}
	public function check_full_house($community)
	{
		$matches = $this->check_match($community);
		if($this->check_has_pairs == true && $this->check_three_of_kind() == true)
		{
			return true;
		}
	}
	public function check_three_of_kind($community)
	{
		$matches = $this->check_match($community);
		foreach ($matches as $abs_value => $cards) {
			if(count($cards) == 3)
			{
				return true;
			}
		}
		return false;
	}
	
	public function check_four($community)
	{
		$matches = $this->check_match($community);
		foreach($matches as $key => $value)
		{
			if(count($value) == 4)
			{
				return true;
			}
		}
		return false;
	}
	public function check_straight($community)
	{
		$abs_array=$this->get_abs_sort($community);
		//low straight check
		$ls_check = true;
		$hs_check = true;
		print_r($abs_array);
		for($i=1; $i < count($abs_array) ; $i++)
		{
			$diff = $abs_array[$i]-$abs_array[$i-1];
			if($diff > 1)
			{
				$ls_check = false;
				break;
			}
		}
		reset($abs_array);
		$start = count($abs_array)-1;
		for($k=$start; $k > 0 ; $k--)
		{
			$diff = $abs_array[$k]-$abs_array[$k-1];
			if($diff > 1)
			{
				$hs_check= false;
				break;
			}
		}

		if(($ls_check==true) || ($hs_check == true))
		{
			return true;
		}
		return false;
	}
	private function get_abs_sort($community)
	{
		$abs_array = array();
		foreach($this->hand as $card)
		{
			$abs_array[] = $card->get_abs_value();
			if($card->get_abs_value()==14)
			{
				$abs_array[]=1; 
			}
		}
		foreach($community as $card)
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
	public function check_straight_flush($community)
	{
		if(($this->check_straight($community) == true )&& ($this->check_flush($community) == true))
		{
			return true;
		}
		return false;
	}
	public function check_royal_flush($comm)
	{
		$abs_array = $this->get_abs_sort($comm);
		if((end($abs_array) == 14) && $this->check_straight_flush($comm))
		{
			return true;
		}
		return false;
	}
	public function get_high_hand($comm)
	{
		if($this->check_royal_flush($comm) == true)
		{
			return 100;
		}
		if($this->check_straight_flush($comm) == true)
		{
			return 99;
		}
		if($this->check_four($comm) == true)
		{
			return 98;
		}
		if($this->check_full_house($comm) == true)
		{
			return 97;
		}
		if($this->check_straight($comm) == true)
		{
			return 96;
		}
		if($this->check_3($comm) == true)
		{
			return 95;
		}
		if($this->check_2pairs($comm) == true)
		{
			return 94;
		}
		if(count($this->check_match) >0 )
		{
			return 93;
		}
		$abs_array=$this->get_abs_sort($community);
		return end($abs_array);
	}
	public function display_cards()
	{
		foreach($this->hand as $card)
		{
			echo $card."\n";
		}
	}
}