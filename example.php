<?
require('config.php');
require('PsigateAccountManager.php');

// ---- Create an account ----
// A full list of possible vars
// can be found in the PSiGate documentation at
// http://www.psigate.com/pages/techsupport.asp
$response = PsigateAccountManager::createAccount(array(
    'AccountID' => 'some-unique-id-99', // used when updating the account as well
    'Name' => 'Bob Joe',
    'Email' => 'jo@no.com',
    'Comments' => 'group_id=5',
    'CardInfo' => array(
        'CardHolder' => 'Bob Joe',
        'CardNumber' => '4111111111111111',
        'CardExpMonth' => '08',
        'CardExpYear' => '11'
)));
print_r($response);

// ---- Update an account ----
$response = PsigateAccountManager::updateAccount('some-unique-id-99', array(
    'Email' => 'jo@noz.com',
));
print_r($response);

// ---- Create a recurring profile ---- 
?>