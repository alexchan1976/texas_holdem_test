<?php

class card {

	private $suite;
	private $value;

	public function __construct($suite,$value)
	{
		$this->suite = $suite;
		$this->value = $value;
	}

	public function get_suite()
	{
		return $this->suite;
	}
	public function get_value()
	{
		return $this->value;
	}

	public function get_abs_value()
	{
		if(is_numeric($this->value) == true)
		{
			return $this->value;
		}
		elseif(is_numeric($this->value) == false && $this->value =="JACK")
		{
			return 11;
		}
		elseif(is_numeric($this->value) == false && $this->value =="QUEEN")
		{
			return 12;
		}
		elseif(is_numeric($this->value) == false && $this->value =="KING")
		{
			return 13;
		}
		elseif(is_numeric($this->value) == false && $this->value =="ACE")
		{
			return 14;
		}

	}
	public function __toString()
	{
		return $this->value .' of '.$this->suite;
	}
}