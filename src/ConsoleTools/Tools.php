<?php
namespace NeoPHP\ConsoleTools;

	/**
	 * Color class.
	 */
	class Tools {

		/**
		 * isUnixLikeOS function.
		 * 
		 * @access public
		 * @static
		 * @return void
		 */
		public static function isUnixLikeOS() {
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				return false;
			} else {
				return true;				
			}
		}		

		/**
		 * clearScreen function.
		 * 
		 * @access public
		 * @static
		 * @return void
		 */
		public static function clearScreen() {
			
			if (self::isUnixLikeOS())
				system('clear');
			else
				system('cls');
		}
	}
