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
	public function getName()
	{
		return $this->name;
	}

	public function addOneCardToHand(card $card)
	{
		$this->hand[] = $card;
	}
	public function addMultipleCards(array $cards)
	{
		if(is_array($cards) == true)
		{
			$this->hand = $cards;	
		}
	}
	public function getHand()
	{
		return $this->hand;
	}
	public function check_flush($community)
	{
		for($i=1 ; $i < count($this->hand) ; $i++)
		{
			if(($this->hand[$i]->getSuite() != $this->hand[$i-1]->getSuite() ))
			{
				return false;
			}
		}
		$suite_in_hand = $this->hand[$i-1]->getSuite();
		for($i=1; $i < count($community) ; $i++){
			if($community[$i]->getSuite() != $suite_in_hand)
			{
				return false;
			}
			if(($community[$i]->getSuite() != $community[$i-1]->getSuite()))
			{
				return false;
			}
		}
		return true;
	}

	public function check_match($community)
	{
		$match_val = array();
		for($i=1 ; $i < count($this->hand) ; $i++)
		{
			if($this->hand[$i]->getAbsValue() == $this->hand[$i-1]->getAbsValue() )
			{
				$match_val[$this->hand[$i]->getAbsValue()][] = array($this->hand[$i], $this->hand[$i-1]);
			}
		}
		foreach($community as $card)
		{
			foreach($this->hand as $h_card)
			{
				if($card->getAbsValue() == $h_card->getAbsValue())
				{
					$match_val[$card->getAbsValue()][] = array($card, $h_card);
				}
			}
		}
		return $match_val;
	}
	public function check_2pairs($comm)
	{
		$matches = $this->check_match($comm);
		if(count($matches) == 0)
		{
			return false;
		}
		if(count($matches) > 1)
		{
			return true;
		}
		return false;
	}
	public function check_full_house($community)
	{
		$matches = $this->check_match($community);
		//print_r($matches);
		if(count($matches) == 0)
		{
			return false;
		}
		$has_pair = 0;
		$has_3 =0;
		foreach($matches as $key => $value)
		{
			if(count($value) == 1)
			{
				$has_pair =1;
			}
			if(count($value) == 2)
			{
				$has_3 = 1;
			}
		}

		if($has_pair == 1 && $has_3 ==1){
			return true;
		}
		return false;
	}
	public function check_3($community)
	{
		$matches = $this->check_match($community);
		foreach($matches as $key => $value)
		{
			if(count($value) == 2)
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
			if(count($value) == 3)
			{
				return true;
			}
		}
		return false;
	}
	public function check_straight($community)
	{
		$abs_array=$this->getAbsSort($community);
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
	private function getAbsSort($community)
	{
		$abs_array = array();
		foreach($this->hand as $card)
		{
			$abs_array[] = $card->getAbsValue();
			if($card->getAbsValue()==14)
			{
				$abs_array[]=1; 
			}
		}
		foreach($community as $card)
		{
			$abs_array[] = $card->getAbsValue();
			if($card->getAbsValue()==14)
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
		$abs_array = $this->getAbsSort($comm);
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
		$abs_array=$this->getAbsSort($community);
		return end($abs_array);
	}
	public function displayCards()
	{
		foreach($this->hand as $card)
		{
			echo $card."\n";
		}
	}
}