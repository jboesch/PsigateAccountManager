<?
require('config.php');
require('PsigateAccountManager.php');

/*
$response = PsigateAccountManager::createAccount(array(
    'AccountID' => 'some-unique-id-99',
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
*/

/*
$response = PsigateAccountManager::updateAccount('some-unique-id-99', array(
    'Email' => 'jo@noz.com',
));
print_r($response);
*/

/*
// Retrieve charge information by a set of conditions
$response = PsigateAccountManager::createCharge('some-unique-id-99', array(
    'StoreID' => 'teststore',
    'SerialNo' => 1,
    'Interval' => 'M',
    'RBTrigger' => 15,
    'ItemInfo' => array(
        'ProductID' => '7shifts',
        'Description' => 'Online Employee Scheduling www.7shifts.com',
        'Quantity' => 1,
        'Price' => 10
    )
));
print_r($response);
*/

/*
$response = PsigateAccountManager::retrieveCharge('some-unique-id-99');
print_r($response);
*/

// To use a set of conditions instead of account id retrieval (above), pass an array.
/*
$response = PsigateAccountManager::retrieveCharge(array(
    'RBCID' => 'something234234'
));
print_r($response);
*/

?>