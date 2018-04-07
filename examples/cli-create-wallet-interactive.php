<?php
chdir(__FILE__);

include("../../../../vendor/autoload.php");

use NeoPHP\ConsoleTools\Interaction\Menu;
use NeoPHP\ConsoleTools\Interaction\Prompt;
use NeoPHP\ConsoleTools\Color;
use NeoPHP\ConsoleTools\Table;
use NeoPHP\ConsoleTools\Tools;
use NeoPHP\Crypto\Wif;

//global CLI Color thingy
$c = new NeoPHP\ConsoleTools\Color();

//setup our header
function printHeader($addition="")
{
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

function printIntro()
{
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
function mainMenu()
{
    global $c;
    
    //clearing the screen:
    Tools::clearScreen();

    //print the header
    printHeader(printIntro());
    
    //setup the menu options
    $arrayMenuOptions = [
        " Generate new ".$c->setBold()->s("encrypted")." wallet ",
        " Generate new ".$c->setBold()->s("unencrypted")." wallet",
        " Encrypt an existing wallet",
        " Donate some NEO/GAS to the creator of SecureNEO",
        " Donate some BTC to the creator of SecureNEO",
        " Donate some ETH to the creator of SecureNEO"
    ];

    //create a new menu
    $menu = new Menu("Select an option by pressing the number in front of it");
    //add the items and set the default (1)
    $menu->additems($arrayMenuOptions)->setDefault(1);

    //set labels
    $menu->setLabel("makeChoice", "Select a menu option")->setLabel("makeChoice", "Select a menu options")->setLabel("makeChoice", "Select a menu options");
    
    //display the menu
    $menu->display(
        function () { 	//function when failing
            //if it fails, clear the screen
            Tools::clearScreen();
            //and reprint the header
            printHeader(printIntro());
        },
        function ($pickedChoice) { // choice function
                
            //picked choice
            if ($pickedChoice == 1) {
                generateWallet(true);
            } elseif ($pickedChoice == 2) {
                generateWallet(false);
            } elseif ($pickedChoice == 3) {
                encryptPrivateKey();
            }
            
            //reset back to stuff
            mainMenu();
        }
    );
}


/**
 * encryptPrivateKey function.
 *
 * @access public
 * @param mixed $error
 * @return void
 */
function encryptPrivateKey($error=false)
{
    //globslize color
    global $c;
    
    //clear the screen
    Tools::clearScreen();

    printHeader("
This screen allows you to encrypt a currently non-encrypted
wallet. To continue, please enter the wallet Wif and then the 
keyphrasa you'd like to encrypt the wallet with.");

    if ($error) {
        echo $c->setBold()->c("red")->s($error)."\n\n";
    }


    $wif = (new Prompt("Enter the Wif"))->pickedValue();
    $first = (new Prompt("Passphrase", false, false, true))->pickedValue();
    $second = (new Prompt("Passphrase (again)", false, false, true))->pickedValue();
    
    if ($first == "" || $wif == "") {
        encryptPrivateKey("Passphrases and/or Wif can't be empty");
        return;
    } elseif ($first != $second) {
        encryptPrivateKey("Passphrases don't match");
        return;
    } elseif (strlen($first)<6) {
        encryptPrivateKey("Passphrases too short (min. 6 characters)");
        return;
    } elseif (!WIF::validateWif($wif)) {
        encryptPrivateKey("Invalid Wif");
        return;
    } else {
        echo "\nPlease wait while we encrypt your wallet...";
        //Open a wallet
        $openWallet = new NeoPHP\NeoWallet($wif);
        $openWallet->encryptWallet($first);
        $walletPrintObject = walletPrint($openWallet);
        //set the variables
        echo "done\n\n";
        echo $walletPrintObject;
    }

    new Prompt("Press <enter> to return to main menu");
}

/**
 * generateWallet function.
 *
 * @access public
 * @param mixed $encrypted
 * @param bool $error (default: false)
 * @return void
 */
function generateWallet($encrypted, $error = false)
{
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
    
    if ($error) {
        echo $c->setBold()->c("red")->s($error)."\n\n";
    }
    
    //create new wallet
    $newWallet = new NeoPHP\NeoWallet();
    
    //check if it's encrypted or not
    if ($encrypted) {
        $first = (new Prompt("Passphrase", false, false, true))->pickedValue();
        $second = (new Prompt("Passphrase (again)", false, false, true))->pickedValue();

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
        } else {
            echo "\nPlease wait while we encrypt your wallet...";
            $newWallet->encryptWallet($first);
        }
    } else {
        echo "\nPlease wait while we create your wallet...";
    }
    
    $walletPrintObject = walletPrint($newWallet);
    //set the variables
    echo "done\n\n";
    echo $walletPrintObject;

    new Prompt("Press <enter> to return to main menu");
}

function walletPrint($walletObject)
{
    global $c;
    
    $return = "";
    
    if ($walletObject->isNEP2()) {
        $encryptedKey = $walletObject->getEncryptedKey();
    } else {
        $wif = $walletObject->getWif();
    }
        
    $address = 	$walletObject->getAddress();
    $privateKey = $walletObject->getPrivateKey();
    $publicKey = $walletObject->getPublicKey();
    
    $return .= $c->setBold()->c("red")->s("Below is the important wallet information. Please write this down\nand keep it in a safe place!, this is not recoverable.")."\n";
    if ($walletObject->isNEP2()) {
        $return .= "Your encrypted key:\t{$encryptedKey}\nYour passphrase:\t<What you've just entered>\n";
    } else {
        $return .= "The Wif key:\t\t{$wif}\n";
    }
    $return .= "The address:\t\t".$address."\n";
    $return .= "\n".$c->setBold()->s('Other information (you probably don\'t need):')."\n";
    $return .= "The private key: \t{$privateKey}\n";
    $return .= "The public key: \t{$publicKey}\n";
    $return .= "\n";
    return $return;
}

//invoke main menu function
mainMenu();
