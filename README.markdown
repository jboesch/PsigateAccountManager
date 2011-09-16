# PSiGate Account Manager PHP Class

This class is meant to give you the ability to quickly access the account manager API through quick method calls.
It's HIGHLY recommended that you read through parts of the Account Manager API PDF located here: http://www.psigate.com/pages/techsupport.asp
It will give you an insight as to what keys you need to post for different methods. If you look at the multiple array data in example.php, you'll notice that those keys
will be the exact same as the ones in the API PDF manual. So yes, RTFM.

## Usage

* See example.php for usage

## Change Log

### Changes in 1.1 (Sept 15, 2011)

* Added debug option (PsigateAccountManager::$debug = true)
* Bug fix: you can now post multi-line tags (see example.php - createCharge method with multiple ItemInfo tags)

### Changes in 1.0 (Sept 3, 2011)

* Launched!
