<?php
namespace NeoPHP\ConsoleTools\Interaction;

use NeoPHP\ConsoleTools\Color;

/**
 * Menu class.
 */
class Menu {
	
	private $title;
	private $items;
	private $default;
	private $labels;
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $title
	 * @return void
	 */
	public function __construct($title=false) {
		$this->title = $title;
		
		//set default labels
		$this->labels = [
			"makeChoice" => "Make a choice",
			"noValidChoice" => "Not a valid choice",
			"outOfBounds" => "Choice out of bounds"
		];
	}
	
	/**
	 * setLabel function.
	 * 
	 * @access public
	 * @param mixed $key
	 * @param mixed $value
	 * @return void
	 */
	public function setLabel($key, $value) {
		if (array_key_exists($key, $this->labels))
			$this->labels[$key] = $value;
		else
			throw new \Exception("Not a valid label");	
			
		return $this;
	}
	
	
	/**
	 * getText function.
	 * 
	 * @access private
	 * @param mixed $key
	 * @return void
	 */
	private function __t($key) {
		if (array_key_exists($key, $this->labels))
			return $this->labels[$key];
		else
			return "NO_TEXT";
	}
	
	/**
	 * addItem function.
	 * 
	 * @access public
	 * @param mixed $itemName
	 * @return void
	 */
	public function addItem($itemName) {
		if (is_null($itemName))
			trigger_error("Item Name can't be empty",E_USER_ERROR);
		$this->items[] = $itemName;
		return $this;
	}
	
	/**
	 * addItems function.
	 * 
	 * @access public
	 * @param array $items (default: [])
	 * @return void
	 */
	public function addItems(array $items = []) {
		foreach ($items as $i)
			$this->addItem($i);
		return $this;			
	}
	
	
	/**
	 * setDefault function.
	 * 
	 * @access public
	 * @return void
	 */
	public function setDefault($default) {
		if (($default) > count($this->items))
			trigger_error("Default is larger than amount of items",E_USER_ERROR);
	}
	
	private function generateMenu($menuItems, $failedfunction, $successFunction) {
		echo $this->title."\n\n";			
		$choice = new Prompt($menuItems.$this->__t("makeChoice"),false,true);
		$c = new Color();
		$item = $choice->pickedValue();

		if ($item == "NaN") {
			$failedfunction();
			//item is 0; not a number
			echo $c->setBold()->c("red")->s($this->__t("noValidChoice")."\n\n");
			return $this->generateMenu($menuItems, $failedfunction, $successFunction);
		} elseif (floatval($item) > count($this->items)) {
			$failedfunction();
			//item is out of bounds
			echo $c->setBold()->c("red")->s($this->__t("outOfBounds")."\n\n");
			return $this->generateMenu($menuItems, $failedfunction, $successFunction);
		} else {
			echo "$item";
			$successFunction($item);
		}
		
		
	}
	
	/**
	 * displayMenu function.
	 * 
	 * @access public
	 * @return void
	 */
	public function display($failedfunction,$successFunction) {
		
		if (count($this->items) == 0)
			trigger_error("No items to be displayed",E_USER_ERROR);				
		
		$menuItems = null;
		$width = strlen(count($this->items));
		foreach ($this->items as $key=>$item){
			$menuItems .= "  ".str_pad(($key+1).".",$width+2).$item."\n";
		}
		
		$menuItems .= "\n";
		
		$result = $this->generateMenu($menuItems, $failedfunction, $successFunction);
		echo "the result is: {$result}";
		
	}
}
