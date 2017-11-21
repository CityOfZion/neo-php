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
	 * hide_term function.
	 * 
	 * @access private
	 * @return void
	 */
	private function hide_term() {
	    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
	        echo "\033[8m";
	    }
	}
	 
	/**
	 * restore_term function.
	 * 
	 * @access private
	 * @return void
	 */
	private function restore_term() {
	    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
	        echo "\033[0m";
	    }
	}	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $question
	 * @return void
	 */
	public function __construct($question, $defaultPick=false, $numbersOnly=false, $passwordField=false) {
		//echo the question
		echo $question.((@$default == "") ? "" : " [{$default}]").": ";
		//read stdin
		$handle = fopen("php://stdin","r");
		
		//hide input
		if ($passwordField) $this->hide_term();
		//trim the handle
		$line = trim(fgets($handle));
		//hide input
		if ($passwordField) $this->restore_term();
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