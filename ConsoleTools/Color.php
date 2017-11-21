<?php
namespace NeoPHP\ConsoleTools;

	/**
	 * Color class.
	 */
	class Color {
		
		/**
		 * string
		 * 
		 * @var mixed
		 * @access private
		 */
		private $string;		

		private $foregroundColor = "";
		private $backgroundColor = "";
		
		private $foregroundColors = [];
		private $backgroundColors = [];
		
		private $options = [];

		
		/**
		 * __construct function.
		 * 
		 * @access public
		 * @return void
		 */
		public function __construct() {
			
			$this->foregroundColors = [
	            'black'        => '30', 'dark_gray'    => '30',
	            'blue'         => '34', 'light_blue'   => '34',
	            'green'        => '32', 'light_green'  => '32',
	            'cyan'         => '36', 'light_cyan'   => '36',
	            'red'          => '31', 'light_red'    => '31',
	            'purple'       => '35', 'light_purple' => '35',
				'brown'        => '33', 'yellow'	   => '33',
	            'light_gray'   => '37', 'white'        => '37',
			];			
			
			$this->backgroundColors = [
				'black'        => '40', 'red'          => '41',
                'green'        => '42', 'yellow'       => '43',
                'blue'         => '44', 'magenta'      => '45',
                'cyan'         => '46', 'light_gray'   => '47',
            ];
            
            $this->reset();
            
		}
		
		private function reset() {
			$this->foregroundColor = $this->backgroundColor = 0;
			$this->options = [];
		}

		/**
		 * s function.
		 * 
		 * @access public
		 * @param mixed $string
		 * @return void
		 */
		public function s($s) {

			$colored_string = "";

            if ($this->backgroundColor != "") {
				$colored_string .= "\033[" . $this->backgroundColor . "m";	            
            }

            if ($this->foregroundColor != "") {
				$colorCode = ";".$this->foregroundColor;
            } else {
	            $colorCode = "";
            }

			$colored_string .= "\033[". implode(";", $this->options) . $colorCode . "m";            
			$colored_string .=  $s . "\033[0m";
			
			$this->reset();
			
			return $colored_string;
			
		}
		
		/**
		 * c function.
		 * 
		 * @access public
		 * @param mixed $foreground_color
		 * @return void
		 */
		public function c($foregroundColor) {
			if (array_key_exists($foregroundColor, $this->foregroundColors))
	            $this->foregroundColor = $this->foregroundColors[$foregroundColor];
			return $this;
		}
		
		/**
		 * b function.
		 * 
		 * @access public
		 * @param mixed $background_color
		 * @return void
		 */
		public function b($backgroundColor) {
			if (array_key_exists($backgroundColor, $this->backgroundColors))
	            $this->backgroundColor = $this->backgroundColors[$backgroundColor];
			return $this;
		}
		
		/**
		 * setBold function.
		 * 
		 * @access public
		 * @return void
		 */
		public function setBold() {
			$this->options[] = 1;
			return $this;
		}
		
		/**
		 * setDim function.
		 * 
		 * @access public
		 * @return void
		 */
		public function setDim() {
			$this->options[] = 2;
			return $this;
		}		

		/**
		 * setUnderline function.
		 * 
		 * @access public
		 * @return void
		 */
		public function setUnderline() {
			$this->options[] = 4;
			return $this;
		}

		/**
		 * setBlink function.
		 * 
		 * @access public
		 * @return void
		 */
		public function setBlink() {
			$this->options[] = 5;
			return $this;

		}
		
		/**
		 * setBlink function.
		 * 
		 * @access public
		 * @return void
		 */
		public function setReverse() {
			$this->options[] = 7;
			return $this;

		}
	}
