<?php
namespace NeoPHP\ConsoleTools\Interaction;

/**
 * Prompt class.
 */
class Prompt {
	
	/**
	 * string
	 * 
	 * @var mixed
	 * @access private
	 */
	private $choice;
	
	/**
	 * __toString function.
	 * 
	 * @access public
	 * @return void
	 */
	public function pickedValue() {
	    return $this->value;
	}
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $question
	 * @return void
	 */
	public function __construct($question, $defaultPick=false, $numbersOnly=false) {
		//echo the question
		echo $question.((@$default == "") ? "" : " [{$default}]").": ";
		//read stdin
		$handle = fopen ("php://stdin","r");
		//trim the handle
		$line = trim(fgets($handle));			
		//close the handle
		fclose($handle);
		
		
		if ($numbersOnly) {
			if (!is_numeric($line)) {
				$line = "NaN";
			}
			
			if ($line == "" && $defaultPick && ($line != "0" && !$allowZero))
				//set the default
				$this->value = (int)$defaultPick;
			else
				//setup the string
				$this->value = (int)$line;		
			
		} else {
			$this->value = $line;
		}
		
		
	}
}	