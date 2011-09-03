<?
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
     * @TODO: Complete this list. Right now it contains
     * about half of what the API offers.
     */
    protected static $_action_keys = array(
        'create_account' => 'AMA01',
        'update_account' => 'AMA02',
        'retrieve_account' => 'AMA05',
        'enable_account' => 'AMA08',
        'disable_account' => 'AMA09',
        'add_credit_card' => 'AMA11',
        'create_charge' => 'RBC01',
        'update_charge' => 'RBC02'
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
    function retrieveAccount($account_id)
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
    function enableAccount($account_id)
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
    function disableAccount($account_id)
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
    function addCreditCard($account_id, $cc_data)
    {

        self::$_action = 'add_credit_card';

        self::_addToRequest('Condition', array(
            'AccountID' => $account_id,
        ));

        self::_addToRequest('CardInfo', $cc_data);

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
    function _addToRequest($key, $data)
    {

        self::$_request[$key] = $data;

    }

    /*
     * Construct the request
     * 
     * @return null
     */
    function _buildRequest()
    {

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
    function _makeRequest()
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // TEMPORARY! @TODO: REMOVE
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