<?php
function _require_all($dir)
{
    // require all php files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        } elseif (is_dir($path)) {
            _require_all($path);
        }
    }
}
_require_all("./../src/");


use NeoPHP\ConsoleTools\Interaction\Menu;
use NeoPHP\ConsoleTools\Interaction\Prompt;
use NeoPHP\ConsoleTools\Color;
use NeoPHP\ConsoleTools\Table;
use NeoPHP\ConsoleTools\Tools;

//global CLI Color thingy
$c = new NeoPHP\ConsoleTools\Color();

//setup our header
function printHeader($addition="") {
	global $c;
	echo "
    _____                          _   _  _____ _____ 
   /  ___|                        | \ | ||  ___|  _  |
   \ `--.  ___  ___ _   _ _ __ ___|  \| || |__ | | | |
    `--. \/ _ \/ __| | | | '__/ _ \ . ` ||  __|| | | |
   /\__/ /  __/ (__| |_| | | |  __/ |\  || |___\ \_/ /
   \____/ \___|\___|\__,_|_|  \___\_| \_/\____/ \___/ 
                   https://github.com/ITSVision/PHPNeo
              Benjamin de Bos <benjamin@its-vision.nl>
             
{$addition}

";
}

function printIntro() {
	global $c;
	return "
A super secure offline NEO wallet generator. By using SecureNEO you make sure no 
one get's hold of your wallet This Linux distribution disables your network devices 
so  you don't have to worry about Spyware, keyloggers, backdoors, etc.

If you're feeling really paranoid, you can always remove your network cable or screw
off the antenna on your device.

You like it? Send some donations, select option 4, 5 or 6 in the menu :)

".$c->setBold()->setBlink()->s("!!! Use at your own risk !!!");
}

//show the main menu
function mainMenu() {
	
	global $c;
	
	//clearing the screen:
	NeoPHP\ConsoleTools\Tools::clearScreen();

	//print the header
	printHeader(printIntro());
	
	//setup the menu options
	$arrayMenuOptions = [
		"🔐  Generate new ".$c->setBold()->s("encrypted")." wallet ",
		"🚫  Generate new ".$c->setBold()->s("unencrypted")." wallet",
		"🗝️  Encrypt an existing wallet using NEP2",
		"💰  Donate some NEO/GAS to the creator or SecureNEO",
		"💰  Donate some BTC to the creator or SecureNEO",
		"💰  Donate some ETH to the creator or SecureNEO"
	];

	//create a new menu
	$menu = new Menu("Select an option by pressing the number in front of it");
	//add the items and set the default (1)
	$menu->additems($arrayMenuOptions)->setDefault(1);

	//set labels	
	$menu->setLabel("makeChoice", "Select a menu option")->setLabel("makeChoice", "Select a menu options")->setLabel("makeChoice", "Select a menu options");
	
	//display the menu
	$menu->display(
		function(){ 	//function when failing
			//if it fails, clear the screen
			Tools::clearScreen();
			//and reprint the header
			printHeader(printIntro());
		},
		function($pickedChoice) { // choice function
				
			//picked choice
			if ($pickedChoice == 1) {
				generateWallet(true);
			} else {
				generateWallet(false);
			}
			
			//reset back to stuff
			mainMenu();
		}
	);
}


/**
 * generateEncryptedKey function.
 * 
 * @access public
 * @return void
 */
function generateWallet($encrypted,$error = false) {
	//globslize color
	global $c;
	
	//clear the screen
	Tools::clearScreen();	

	if ($encrypted) {
	//printing header
	printHeader("This screen allows you to generate an encrypted wallet. To
continue, please enter a passphrase. This will be the password
you need to enter when you want to decrypt this wallet.");
	} else {
		printHeader("This screen will create an unencrypted wallet for you.");		
	}
	
	if ($error)
		echo $c->setBold()->c("red")->s($error)."\n\n";
	
	//create new wallet
	$newWallet = new NeoPHP\NeoWallet();
	
	//check if it's encrypted or not
	if ($encrypted) {
		$first = (new Prompt("Passphrase"))->pickedValue();
		$second = (new Prompt("Passphrase (again)"))->pickedValue();

		//validate the key
		if ($first == "") { 
			generateWallet($encrypted, "Passphrases can't be empty");
			return;
		} elseif ($first != $second) {
			generateWallet($encrypted, "Passphrases don't match");
			return;			
		} elseif (strlen($first)<6) {
			generateWallet($encrypted, "Passphrases too short (min. 6 characters)");
			return;
		} else
		
		echo "\nPlease wait while we encrypt your wallet...";
		$newWallet->encryptWallet($first);
	} else {
		echo "\nPlease wait while we create your wallet...";
	}

	//set the variables
	if ($encrypted)
		$encryptedKey = $newWallet->getEncryptedKey();
	else
		$wif = $newWallet->getWif();

	$address = 	$newWallet->getAddress();
	$privateKey = $newWallet->getPrivateKey();
	$publicKey = $newWallet->getPublicKey();
	echo "done\n\n";
	
	echo $c->setBold()->c("red")->s("Below is the important wallet information. Please write this down\nand keep it in a safe place!, this is not recoverable.")."\n";
	
	if ($encrypted)
		echo "Your encrypted key:\t{$encryptedKey}\nYour passphrase:\t<What you've just entered>\n";
	else
		echo "The Wif key:\t\t{$wif}\n";
		
	echo "The address:\t\t".$newWallet->getAddress()."\n";
	
	echo "\nOther information:\n";
	echo "The private key: \t{$privateKey}\n";
	echo "The public key: \t{$publicKey}\n";
	
	echo "\n";
	
	new Prompt("Press <enter> to return to main menu");
	
	
}




//invoke main menu function
mainMenu();
/*
NeoPHP\ConsoleTools\Tools::clearScreen();
generateWallet(true);
echo "gelukt!";
*/



