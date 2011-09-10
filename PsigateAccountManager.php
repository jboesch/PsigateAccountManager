<?
/**
 * A simple PHP API wrapper for PSiGate Account Manager API requests.
 * Stay up to date on Github: https://github.com/jboesch/PsigateAccountManager
 *
 * PHP version 5
 *
 * @author     Jordan Boesch <jordan@7shifts.com>
 * @license    Dual licensed under the MIT and GPL licenses.
 */
class PsigateAccountManagerException extends Exception {}
class PsigateAccountManager {

    /*
     * The action that gets set in each method. Then
     * retrieved with self::$_action_keys[self::$_action]
     */
    protected static $_action = '';

    /*
     * Holds the final request data array
     */
    protected static $_final_request = array();

    /*
     * The request array that we add to
     */
    protected static $_request = array();

    /*
     * Any action keys that are defined in our methods below.
     * Each have a corresponding code that gets used in
     * our request.
     * @TODO: Complete this list.
     */
    protected static $_action_keys = array(
        'create_account' => 'AMA01',
        'update_account' => 'AMA02',
        'retrieve_account' => 'AMA05',
        'enable_account' => 'AMA08',
        'disable_account' => 'AMA09',
        'add_credit_card' => 'AMA11',
        'retrieve_charge' => 'RBC00',
        'create_charge' => 'RBC01',
        'update_charge' => 'RBC02',
        'delete_charge' => 'RBC04',
    );

    /*
     * Create an account
     *
     * Array
        (
            [AccountID] => SomethingUnique
            [Name] => John Smith
            [Company] => PSiGate Inc.
            [Address1] => 145 King St.
            [Address2] => 2300
            [City] => Toronto
            [Province] => Ontario
            [Postalcode] => M5H 1J8
            [Country] => Canada
            [Phone] => 1-905-123-4567
            [Fax] => 1-905-123-4568
            [Email] => support@psigate.com
            [Comments] => No Comment Today
            [CardInfo] => Array
                (
                    [CardHolder] => John Smith
                    [CardNumber] => 4005550000000019
                    [CardExpMonth] => 08
                    [CardExpYear] => 11
                )

        )
     *
     * @param array $account_data An array of data for the account creation. See possible keys above.
     * @return array
     */
    public static function createAccount($account_data)
    {

        self::$_action = 'create_account';
        self::_addToRequest('Account', $account_data);
        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Update an account
     *
     * Array
        (
            [Name] => John Smith
            [Company] => PSiGate Inc.
            [Address1] => 145 King St.
            [Address2] => 2300
            [City] => Toronto
            [Province] => Ontario
            [Postalcode] => M5H 1J8
            [Country] => Canada
            [Phone] => 1-905-123-4567
            [Fax] => 1-905-123-4568
            [Email] => support@psigate.com
            [Comments] => No Comment Today
            [CardInfo] => Array
                (
                    [CardHolder] => John Smith
                    [CardNumber] => 4005550000000019
                    [CardExpMonth] => 08
                    [CardExpYear] => 11
                )

        )
     *
     * @param string $account_id The account you're updating
     * @param array $account_data An array of data for the account creation. See possible keys above.
     * @return array
     */
    public static function updateAccount($account_id, $account_data_to_update)
    {

        self::$_action = 'update_account';

        self::_addToRequest('Condition', array(
            'AccountID' => $account_id,
        ));

        self::_addToRequest('Update', $account_data_to_update);

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Get account info
     *
     * @param string $account_id The account you're retrieving
     * @return array
     */
    public static function retrieveAccount($account_id)
    {

        self::$_action = 'retrieve_account';

        self::_addToRequest('Condition', array(
            'AccountID' => $account_id,
        ));

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Enable an account
     *
     * @param string $account_id The account you're performing the action on
     * @return array
     */
    public static function enableAccount($account_id)
    {

        self::$_action = 'enable_account';

        self::_addToRequest('Condition', array(
            'AccountID' => $account_id,
        ));

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Disable an account
     *
     * @param string $account_id The account you're performing the action on
     * @return array
     */
    public static function disableAccount($account_id)
    {

        self::$_action = 'disable_account';

        self::_addToRequest('Condition', array(
            'AccountID' => $account_id,
        ));

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Add a credit card
     *
     * Array =>
        (
            [CardHolder] => John Smith
            [CardNumber] => 4005550000000019
            [CardExpMonth] => 08
            [CardExpYear] => 11
        )
     *
     * @param string $account_id The account you're performing the action on
     * @param array $cc_data The credit card data you're updating. See above.
     * @return array
     */
    public static function addCreditCard($account_id, $cc_data)
    {

        self::$_action = 'add_credit_card';

        self::_addToRequest('Account', array(
            'AccountID' => $account_id,
            'CardInfo' => $cc_data
        ));

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Create a charge
     *
     * @param string $account_id The account id you're creating the charge for
     * @param array $data The charge data
     */
    public static function createCharge($account_id, $data)
    {

        self::$_action = 'create_charge';

        $data['AccountID'] = $account_id;
        self::_addToRequest('Charge', $data);

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Update a charge
     *
     * @param string $rbc_id The RBCID identifier
     * @param array $data The new data to set for updating the charge
     */
    public static function updateCharge($rbc_id, $data)
    {

        self::$_action = 'update_charge';

        self::_addToRequest('Condition', array(
            'RBCID' => $rbc_id    
        ));

        self::_addToRequest('Update', $data);

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Delete a charge
     *
     * @param string $rbc_id The RBCID
     */
    public static function deleteCharge($rbc_id)
    {

        self::$_action = 'delete_charge';

        self::_addToRequest('Condition', array(
            'RBCID' => $rbc_id
        ));

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Retrieve charge by a set of conditions
     *
     * @param array|string $conditions The keys for conditions (AccountID => 'blah', 'RBCID' => '234') or AccountID
     * @return array
     */
    public static function retrieveCharge($conditions)
    {

        self::$_action = 'retrieve_charge';

        if(is_array($conditions))
        {
            self::_addToRequest('Condition', $conditions);
        }
        // Or else we can assume we're passing in an account ID
        else
        {
            self::_addToRequest('Condition', array(
                'AccountID' => $conditions
            ));
        }

        $response = self::_makeRequest();

        return $response;

    }

    /*
     * Add some key/val pairs to the request
     *
     * @param string $key The key wer'e adding
     * @param array $data The data that we're putting into the request key
     * @return null
     */
    protected static function _addToRequest($key, $data)
    {

        self::$_request[$key] = $data;

    }

    /*
     * Construct the request
     * 
     * @return null
     */
    protected static function _buildRequest()
    {

        if(!defined('PSIGATE_CID'))
        {
            throw new PsigateAccountManagerException('PSIGATE_CID is not defined');
        }

        if(!defined('PSIGATE_USER_ID'))
        {
            throw new PsigateAccountManagerException('PSIGATE_USER_ID is not defined');
        }

        if(!defined('PSIGATE_PASSWORD'))
        {
            throw new PsigateAccountManagerException('PSIGATE_PASSWORD is not defined');
        }

        if(!function_exists('curl_init'))
        {
            throw new PsigateAccountManagerException('This class requires cURL. Looks like you don\'t have it installed.');        
        }

        // Deault request data
        $request_data = array(
            'CID' => PSIGATE_CID,
            'UserID' => PSIGATE_USER_ID,
            'Password' => PSIGATE_PASSWORD,
            'Action' => self::$_action_keys[self::$_action]
        );

        // Add any extra
        foreach(self::$_request as $key => $data)
        {
            $request_data[$key] = $data;
        }

        self::$_final_request = $request_data;

    }

    /*
     * Send the request over the wire
     *
     * @return array
     */
    protected static function _makeRequest()
    {

        self::_buildRequest();

        $xml_inst = new SimpleXMLElement("<?xml version=\"1.0\"?><Request></Request>");

        // function call to convert array to xml
        self::_array_to_xml(self::$_final_request, $xml_inst);
        $post_data = $xml_inst->asXML();

        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL, PSIGATE_URL); // set url to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 40); // times out after 40s
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); // add POST fields
        // You should normally leave this on. But I'll assume you know what you're doing ;)
        if(defined('PSIGATE_DISABLE_SSL') && PSIGATE_DISABLE_SSL === true)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        $result = curl_exec($ch); // run the whole process
        if (curl_errno($ch)) {
           print curl_error($ch);
        } else {
           curl_close($ch);
        }

        $response = json_decode(json_encode(simplexml_load_string($result)), true);

        // Reset
        self::$_request = array();

        return $response;


    }

    /*
     * Convert array to XML.
     *
     * @param $request_data array The array we're wanting to convert
     * @param $xml_inst object The simplexml object instance
     * @return string
     */
    protected static function _array_to_xml($request_data, &$xml_inst)
    {

        foreach($request_data as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_inst->addChild("$key");
                    self::_array_to_xml($value, $subnode);
                }
                else{
                    self::_array_to_xml($value, $xml_inst);
                }
            }
            else {
                $xml_inst->addChild("$key","$value");
            }
        }
    }

}
?>