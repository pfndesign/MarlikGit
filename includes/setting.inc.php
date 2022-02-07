<?php

use voku\helper\AntiXSS;

/**
 * setting managment class
 *
 * setting management class for adding the setting to a database or local and creating low-cost updatable setting using hit function
 * This class also provides the create_tables function for creating the setting table
 * what is a hittable setting? 
 * hittable settings are stored in the database and values are not edited using add or update function but to update a hittable setting one must call the hit function
 * each time hit function is called a record will be added to the hits table, when it's time to collect hits user function will be called and the setting value will be updated
 * ? why anti xss?
 * the way that values are stored in .setting file makes it vulnerable to XSS attack Intentionally or unIntentionally
 * .setting file is basically a .env file if a value gets corrupted phpenv can't read the data because of these we need antixss 
 * you can however disable this by "xss_clean_setting" setting
 * @package setting	
 * @version 1.0.1
 * @author peyman farahmand pfndesigen@gmail.com	
 */
class Setting
{
    // {{{ properties
    /**
     * autosave
     * auto save after each operation
     * @var bool
     */
    private $autosave = true;
    /**
     * rawdata
     * setting raw data
     * @var string
     */
    private $rawdata = "";
    /**
     * settingtablename
     * setting table name
     * @var string
     */
    private $settingtablename  = "setting";
    /**
     * hitstablename
     * hits table name
     * @var string
     */
    private $hitstablename  = "settinghits";
    /**
     * data
     * setting data
     * @var array
     */
    private $data;
    /**
     * parsedata
     *  $data value parse and cleand
     * @var array
     */
    private $parsedata = [];
    /**
     * updated
     * is a setting value updated
     * @var bool
     */
    private $updated = false;
    /**
     * added
     * is new setting value added
     * @var bool
     */
    private $added = false;
    /**
     * movedToDb
     * array of setting key / value that moved from local to db
     * @var array
     */
    private $movedToDb = [];
    /**
     * removedFromDb
     * removed setting keys from database
     * @var array
     */
    private $removedFromDb = [];
    /**
     * dbHitData
     * hitable and hitconfig related to settings in database
     * @var array
     */
    private $dbHitData = [];
    /**
     * updatedHitConfigs
     * setting keys that hitconfigs are changed
     * @var array
     */
    private $updatedHitConfigs = [];
    // }}}
    /**
     * __construct
     *
     * @param  bool $autosave auto save operation
     * @param  string $path setting file path | default BASE_PATH
     * @param  string $filename setting file name | default ".setting"
     * @param  bool $createtables create tables needed | default false
     * @param  string $settingtablename setting table name | default "setting"
     * @param  string $hitstablename setting hit table name | default "settinghits"
     * @return void
     */
    function __construct($autosave = true, $path = BASE_PATH, $filename = '.setting', $createtables = false, $settingtablename = "setting", $hitstablename = "settinghits")
    {
        // auto save
        $this->autosave = $autosave;
        //load settings
        try {
            $this->data = Dotenv\Dotenv::createArrayBacked($path, $filename)->load();
            $this->rawdata = file_get_contents($path . $filename);
        } catch (Dotenv\Exception\InvalidPathException $e) {
            //show error 
            //setting not found
            die($e->getMessage());
        }
        $this->settingtablename = $settingtablename;
        $this->hitstablename = $hitstablename;
        //filter settings
        $this->cleanformat();
        //install tables
        if ($createtables)
            $this->create_tables();
    }
    /**
     * get
     * - get setting value by specific key (multiple keys supported)
     * - for setting keys that are located in database none parse data will always return "STORE:DB"
     * @param  string $key setting key
     * @param  string $default default value
     * @param  bool $returnparse retrun parse value or raw value
     * @param  string|null $modifier modifier function name ( only works when returnparse is true and if setting is modified)
     * @return array|string|int|float|bool setting value
     * @access public
     */
    public function get($key, $default, $returnparse = true, $modifier = null)
    {
        // return spesific set of keys
        if (is_array($key)) {
            $modifierexists = !is_null($modifier) && ((is_string($modifier) && function_exists($modifier)) || (is_array($modifier) && isset($modifier[0], $modifier[1]) && method_exists($modifier[0], $modifier[1])));
            $filteredsetting = array_filter($returnparse ? $this->parsedata : $this->data, function ($settingkey) use ($key) {
                return in_array($settingkey, $key);
            }, ARRAY_FILTER_USE_KEY);
            //modifier
            if ($returnparse && count($filteredsetting) && $modifierexists) {
                //xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $antiXss = new AntiXSS();
                foreach ($filteredsetting as $settingkey => $settingvalue) {
                    // if key modified
                    if ($this->is_modified($settingvalue)) {
                        $modifiedvalue = call_user_func($modifier, str_replace("modified:", "", $settingvalue));
                        //xss clean
                        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                            $cleanvalue = $antiXss->xss_clean($modifiedvalue);
                        else
                            $cleanvalue = $modifiedvalue;
                        $filteredsetting[$settingkey] = $cleanvalue;
                    }
                }
                return $filteredsetting;
            } else {
                return count($filteredsetting) ? $filteredsetting : $default;
            }
        }
        //return single key
        if ($returnparse) {
            //modifier
            if (!is_null($modifier) && ((is_string($modifier) && function_exists($modifier)) || (is_array($modifier) && isset($modifier[0], $modifier[1]) && method_exists($modifier[0], $modifier[1])))) {
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $antiXss = new AntiXSS();
                // if key exist and modified
                if (isset($this->data[$key]) && $this->is_modified($this->data[$key])) {
                    $modifiedvalue = call_user_func($modifier, str_replace("modified:", "", $this->data[$key]));
                    //xss clean
                    if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                        $cleanvalue = $antiXss->xss_clean($modifiedvalue);
                    else
                        $cleanvalue = $modifiedvalue;
                    return $cleanvalue;
                } elseif (isset($this->parsedata[$key]) && $this->is_modified($this->parsedata[$key])) {
                    //value is in database
                    $modifiedvalue = call_user_func($modifier, str_replace("modified:", "", $this->parsedata[$key]));
                    //xss clean
                    if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                        $cleanvalue = $antiXss->xss_clean($modifiedvalue);
                    else
                        $cleanvalue = $modifiedvalue;
                    return $cleanvalue;
                } elseif (isset($this->data[$key])) {
                    return isset($this->parsedata[$key]) ? $this->parsedata[$key] : $default;
                }
                return $default;
            } else {
                return isset($this->parsedata[$key]) ? $this->parsedata[$key] : $default;
            }
        } else {
            return isset($this->data[$key]) ? $this->data[$key] : $default;
        }
    }
    /**
     * add
     * add new setting option (multiple add supported)
     * * recommended to always use "database" location for storing values that are updating rapidly
     * * for using bluk mode $value array keys must be same as $key both length and name otherwise $value will be considered as single array value and will be applied to all keys
     * @throws Exception If setting value type is incorrect or hitable setting location is in local
     * @param  string|array $key setting key
     * @param  mixed|array $value setting value | STORE:MOVE for moving save location between database <> local
     * @param  string|null $modifier modifier function name
     * @param  string|array $location store location | "local" or "database" 
     * @param  bool $serialize serialize array or object values or use json_encode
     * @param  array $hitconfig hitable setting config
     * example :
     * <code>
     * $settinghitconfig = [
     *  "minupdaterate" => "1minute",
     *  "collectfunction" => false,
     *  "deletehitsaftercollect" => true,
     * ];
     * </code>
     * config info:
     *   + minupdaterate :  minimum update rate after that hit data will be collected from database and setting key will update  (datetime)
     *      - - examples : 1second,1minute,1hour 
     *      - - default : 1minute
     *   + collectfunction : function that run when hits are collected and sat into the setting table  (callable)
     *      - - examples : [$this, "functionname"],["classname", "functionname"],"functioname"
     *      + args : accepts 5 args
     *          - - $settingkey : hitable setting key
     *          - - $hitcount : number of hits after last update
     *          - - $settingvalue : setting value
     *          - - $classrefrence : refrence to setting class
     *   + deletehitsaftercollect : keep the hit records in database or delete hits after update is done and collectfunction is called  (bool)
     * * hitable config is only available when setting key location is database
     * * in bluk add mode hitconfig will be refrenced with setting key
     * @return bool return the true on success
     * @access public
     */
    public function add($key, $value, $modifier = null, $location = "local", $serialize = false, $hitconfig = [])
    {

        // check for xss
        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
            $antiXss = new AntiXSS();
        // allow location to be an array
        if (!is_array($location)) {
            if (is_array($key))
                $location = array_fill(0, count($key), $location); // allow applying one location for multiple keys
            else
                $location = [0 => $location];
        }
        // if key and value is array
        if (!is_array($value)) {
            if (is_array($key))
                $value = array_fill_keys(array_values($key), $value); // allow applying one value for multiple keys
            else
                $value = [$key => $value];
        } elseif (is_array($value) && ((!is_array($key) && !isset($value[$key])) ||  (is_array($key) && array_values($key) != array_keys($value)))) {
            // key is string and value type is array
            $value = is_array($key) ? array_fill_keys(array_values($key), $value) : [$key => $value];
        }
        if (!is_array($key))
            $key = [$key];
        // check if modifier function exists
        $modifierexists = !is_null($modifier) && $this->is_function_valid($modifier);
        foreach ($key as $keyindex => $keyname) {
            if (!isset($value[$keyname]))
                continue;
            $cleanvalue = $castvalue = $value[$keyname];
            if ($modifierexists) {
                $cleanvalue  = $castvalue = "modified:" . call_user_func($modifier, $this->is_modified($value[$keyname]) ? str_replace("modified:", "", $value[$keyname]) : $value[$keyname], $this->is_modified($value[$keyname]), $serialize);
            } else {
                // check for xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $cleanvalue = $antiXss->xss_clean($value[$keyname]);
                else
                    $cleanvalue = $value[$keyname];
                //flated value
                try {
                    $castvalue = $this->castTypeToString($cleanvalue, $serialize);
                } catch (Exception $e) {
                    //invalid value
                    throw new Exception('value type is not valid');
                    continue;
                }
            }
            // new key
            if (!isset($this->data[$keyname]) && (!is_string($value[$keyname]) || is_string($value[$keyname]) && $value[$keyname] != "STORE:MOVE")) {
                $this->added = true;
                //cast values
                $this->data[$keyname] = isset($location[$keyindex]) && $location[$keyindex] ==  "local" ? $castvalue : "STORE:DB";
                $this->parsedata[$keyname] = $cleanvalue;
            } elseif (isset($this->data[$keyname]) && (!is_string($value[$keyname]) || is_string($value[$keyname]) && $value[$keyname] != "STORE:MOVE")) {
                //key exists
                $rawdata = isset($location[$keyindex]) && $location[$keyindex] ==  "local" ? $castvalue : "STORE:DB";
                // if values is changed update
                if ($cleanvalue !== $this->parsedata[$keyname] || $this->data[$keyname] !== $rawdata) {
                    $this->data[$keyname] = $rawdata;
                    $this->parsedata[$keyname] = $cleanvalue;
                    $this->updated = true;
                }
            } else if ($value[$keyname] == "STORE:MOVE") {
                // move setting from db to local or other way around
                if ($this->data[$keyname] == "STORE:DB" && isset($location[$keyindex]) && $location[$keyindex] ==  "local") {
                    $this->removedFromDb[] = $keyname;
                    //save the last parse value to the data
                    // apply modifier when moving data 
                    $newdata =  $modifierexists ? "modified:" . call_user_func($modifier, $this->is_modified($this->parsedata[$keyname]) ? str_replace("modified:", "", $this->parsedata[$keyname]) : $this->parsedata[$keyname], $this->is_modified($this->parsedata[$keyname]), $serialize) : $this->parsedata[$keyname];

                    try {
                        if ($modifierexists)
                            $this->parsedata[$keyname]  = $this->data[$keyname] = $newdata;
                        else
                            $this->data[$keyname] = $this->castTypeToString($this->parsedata[$keyname], $serialize);
                    } catch (Exception $e) {
                        //invalid value
                        continue;
                    }
                    unset($this->dbHitData[$keyname]);
                    $this->updated = true;
                } elseif ($this->data[$keyname] != "STORE:DB" && isset($location[$keyindex]) && $location[$keyindex] ==  "database") {
                    // apply modifier when moving data 
                    $newdata = $modifierexists ? "modified:" . call_user_func($modifier, $this->is_modified($this->data[$keyname]) ? str_replace("modified:", "", $this->data[$keyname]) : $this->data[$keyname], $this->is_modified($this->data[$keyname]), $serialize) : $this->data[$keyname];
                    $this->movedToDb[] = [
                        "name" => $keyname,
                        "data" => $newdata
                    ];
                    //change the store location
                    $this->data[$keyname] = "STORE:DB";
                    // change parse data when data is modified
                    if ($modifierexists)
                        $this->parsedata[$keyname] = $newdata;
                    $this->updated = true;
                }
            }
            //set hit config if location is database
            if (count($hitconfig) && isset($location[$keyindex]) && $location[$keyindex] == "database") {
                $settinghitconfig = isset($hitconfig[$keyname]) ? $hitconfig[$keyname] : $hitconfig;
                $settinghitconfigdefault = [
                    "minupdaterate" => "1minute",
                    "collectfunction" => false,
                    "deletehitsaftercollect" => true,
                ];
                $settinghitconfig = array_merge($settinghitconfigdefault, $settinghitconfig);
                // change class instance to classname
                if ($this->is_function_valid($settinghitconfig['collectfunction']) && is_array($settinghitconfig['collectfunction']) && is_object($settinghitconfig['collectfunction'][0]))
                    $settinghitconfig['collectfunction'][0] = get_class($settinghitconfig['collectfunction'][0]);
                // exist and hitable
                //set next update time
                $settinghitconfig['nextupdate'] = strtotime("+" . $settinghitconfig['minupdaterate']);
                if (isset($this->dbHitData[$keyname]) && $settinghitconfig !== $this->dbHitData[$keyname]['hitconfig']) {
                    // new config
                    $this->dbHitData[$keyname]['hitable'] = true;
                    $this->dbHitData[$keyname]['hitconfig'] = $settinghitconfig;
                    $this->updatedHitConfigs[] = $keyname;
                } elseif (!isset($this->dbHitData[$keyname])) {
                    //not exist or not hitable
                    $this->dbHitData[$keyname] = ['hitable' => true, 'hitconfig' => $settinghitconfig];
                    $this->updatedHitConfigs[] = $keyname;
                }
            } elseif (count($hitconfig)  && isset($location[$keyindex]) && $location[$keyindex] != "database") {
                throw new Exception("hitable setting location must be in database");
                return false;
            } elseif (!count($hitconfig) && isset($this->dbHitData[$keyname])) {
                //convert hitable setting to normal
                $this->dbHitData[$keyname] = ['hitable' => false, 'hitconfig' => null, "deleteconfig" => true];
                $this->updatedHitConfigs[] = $keyname;
            }
        }
        //update
        if ($this->autosave)
            $this->save();

        return true;
    }
    /**
     * update
     * update setting option (multiple update supported)
     * * recommended to always use "database" location for storing values that are updating rapidly
     * * for using bluk mode $value array keys must be same as $key both length and name otherwise $value will be considered as single array value and will be applied to all keys
     * @param  string|array $key setting key
     * @param  mixed|array $value setting value | STORE:MOVE for moving save location
     * @param  string|null $modifier modifier function name
     * @param  string|array $location store location | "local" or "database" 
     * @param  bool $serialize serialize array or object values or use json_encode
     * @param  array $hitconfig hitable setting config
     * example :
     * <code>
     * $settinghitconfig = [
     *  "minupdaterate" => "1minute",
     *  "collectfunction" => false,
     *  "deletehitsaftercollect" => true,
     * ];
     * </code>
     * config info:
     *   + minupdaterate :  minimum update rate after that hit data will be collected from database and setting key will update  (datetime)
     *      - - examples : 1second,1minute,1hour 
     *      - - default : 1minute
     *   + collectfunction : function that run when hits are collected and sat into the setting table  (callable)
     *      - - examples : [$this, "functionname"],["classname", "functionname"],"functioname"
     *      + args : accepts 5 args
     *          - - $settingkey : hitable setting key
     *          - - $hitcount : number of hits after last update
     *          - - $settingvalue : setting value
     *          - - $classrefrence : refrence to setting class
     *   + deletehitsaftercollect : keep the hit records in database or delete hits after update is done and collectfunction is called  (bool)
     * * hitable config is only available when setting key location is database
     * * in bluk add mode hitconfig will be refrenced with setting key
     * @return bool return the true on success
     * @access public
     */
    public function update($key, $value, $modifier = null, $location = "local", $serialize = false, $hitconfig = [])
    {
        return $this->add($key, $value, $modifier, $location, $serialize, $hitconfig);
    }
    /**
     * remove
     * remove setting by key or keys (multiple remove supported)
     * @param  string|array $key setting key
     * @return void
     * @access public
     */
    public function remove($key)
    {
        if (!isset($this->data[$key]))
            return true;
        // $key could be both string or array or keys
        if (!is_array($key))
            $key = [$key];

        foreach ($key as $bulkkey) {
            // key is not stored in database
            if ($this->data[$bulkkey] == "STORE:DB") {
                //key stored in db
                $this->removedFromDb[] = $bulkkey;
            }
            unset($this->data[$bulkkey], $this->parsedata[$bulkkey], $this->dbHitData[$bulkkey]);
        }
        $this->updated = true;
        if ($this->autosave)
            $this->save();
    }
    /**
     * hit
     * add hits for hitable setting in setting hits table and collect it based on hitconfig in settings table to update setting based on update rate
     * @throws Exception If setting key is not hitable or value type is not valid
     * @param  string $key hitable setting key
     * @return bool true on success | false when setting key not exists or is not hitable
     * @access public
     */
    public function hit($key)
    {
        global $db;
        // first of all check if setting key exists and hitable
        if ($this->is_hitable($key)) {
            //insert hit
            $db->insert($this->hitstablename, [
                "setting_id" => $this->dbHitData[$key]['id'],
                "date" => date('Y-m-d H:i:s.') . preg_replace("/^.*\./i", "", microtime(true))
            ]);
            // is it time to collect ?
            if ($this->is_hitable_need_update($key)) {
                //time is up
                if (isset($this->dbHitData[$key]['hitconfig']['deletehitsaftercollect']) && $this->dbHitData[$key]['hitconfig']['deletehitsaftercollect']) {
                    // delete hits 
                    $count = $db->count($this->hitstablename, [
                        "setting_id" => $this->dbHitData[$key]['id']
                    ]);
                    $db->delete($this->hitstablename, [
                        "setting_id" => $this->dbHitData[$key]['id']
                    ]);
                } else {
                    //keep hits
                    $mktime = preg_replace("/^.*\./i", "", microtime(true));
                    $count = $db->count($this->hitstablename, [
                        //collect hits from the start of the timer to now
                        "date[>=]" => date('Y-m-d H:i:s.u', strtotime("-" . $this->dbHitData[$key]['hitconfig']['minupdaterate'] . " " . date('Y-m-d H:i:s.u', $this->dbHitData[$key]['hitconfig']['nextupdate']))),
                        "date[<=]" => date('Y-m-d H:i:s.') . sprintf("%04s", $mktime),
                        "setting_id" => $this->dbHitData[$key]['id']
                    ]);
                }
                //collect function call
                if (isset($this->dbHitData[$key]['hitconfig']['collectfunction']) && $this->is_function_valid($this->dbHitData[$key]['hitconfig']['collectfunction'])) {
                    //call collect function
                    $hitdata = call_user_func($this->dbHitData[$key]['hitconfig']['collectfunction'], $key, $count, $this->parsedata[$key], $this);
                } else {
                    // just sample counter
                    $hitdata = is_numeric($this->parsedata[$key]) ? $this->parsedata[$key] + $count : $count;
                }
                // update hit rate
                $this->dbHitData[$key]['hitconfig']['nextupdate'] = strtotime("+" . $this->dbHitData[$key]['hitconfig']['minupdaterate']);
                // set new data
                try {
                    $this->data[$key] = $this->data[$key] != "STORE:DB" ? $this->castTypeToString($hitdata) : $this->data[$key];
                } catch (Exception $e) {
                    //invalid value
                    return false;
                }
                // check for xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1") {
                    $antiXss = new AntiXSS();
                    $cleanvalue = $antiXss->xss_clean($hitdata);
                } else {
                    $cleanvalue = $hitdata;
                }
                //flated value
                try {
                    $castvalue = $this->castTypeToString($cleanvalue);
                } catch (Exception $e) {
                    //invalid value
                    return false;
                }
                $this->parsedata[$key] = $castvalue;
                // hit config updated
                $this->updatedHitConfigs[] = $key;
                $this->updated = true;

                if ($this->autosave)
                    $this->save();

                return true;
            }
            return true;
        } else {
            throw new Exception('setting key is not hitable');
            return false;
        }
    }
    /**
     * hitable_database_count
     * return setting key hit count from database
     * @param  string $key setting key
     * @param  string $datafrom date string
     * @param  string $dateto date string
     * @return int|bool
     * @access public
     */
    public function hitable_database_count($key, $datafrom = null, $dateto = null)
    {
        global $db;
        if ($this->is_hitable($key)) {
            $args = [
                "setting_id" => $this->dbHitData[$key]['id']
            ];
            if (!is_null($datafrom) && strtotime($datafrom))
                $args['date[>=]'] = $datafrom;
            if (!is_null($dateto) && strtotime($dateto))
                $args['date[<=]'] = $dateto;
            return $db->count($this->hitstablename, $args);
        } else {
            return false;
        }
    }
    /**
     * get_all
     * get all settings
     * @param  bool $returnparse
     * @param  string|null $modifier modifier function name ( only works when returnparse is true and if setting is modified)
     * @return array settings
     * @access public
     */
    public function get_all($returnparse = true, $modifier = null)
    {
        if ($returnparse && !is_null($modifier) && $this->is_function_valid($modifier)) {
            //xss
            if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                $antiXss = new AntiXSS();
            //decryption
            foreach ($this->parsedata as $settingkey => $settingvalue) {
                // if key encrypted
                if ($this->is_modified($this->data[$settingkey])) {
                    $decryptionvalue = call_user_func($modifier, str_replace("modified:", "", $this->data[$settingkey]));
                    //xss clean
                    if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                        $cleanvalue = $antiXss->xss_clean($decryptionvalue);
                    else
                        $cleanvalue = $decryptionvalue;
                    $this->parsedata[$settingkey] = $cleanvalue;
                }
            }
        }
        return $returnparse ? $this->parsedata : $this->data;
    }
    /**
     * create_tables
     * create tables for settings
     * @return bool true on success
     * @access public
     */
    public function create_tables()
    {
        global $db, $prefix;
        //create setting table
        try {
            $db->create($this->settingtablename, [
                "id" => [
                    "INT",
                    "NOT NULL",
                    "AUTO_INCREMENT",
                    "PRIMARY KEY"
                ],
                "name" => [
                    "VARCHAR(255)",
                    "NOT NULL",
                    "UNIQUE"
                ],
                "data" => [
                    "VARCHAR(1000)",
                    "NOT NULL"
                ],
                "hitable" => [
                    "BOOLEAN",
                    "DEFAULT FALSE"
                ],
                "hitable" => [
                    "BOOLEAN",
                    "DEFAULT FALSE"
                ],
                "hitconfig" => [
                    "VARCHAR(255)",
                    "NULL"
                ],
            ], ["ENGINE" => "InnoDB"]);
            //create setting hits table
            $db->create($this->hitstablename, [
                "id" => [
                    "INT",
                    "NOT NULL",
                    "AUTO_INCREMENT",
                    "PRIMARY KEY"
                ],
                "setting_id" => [
                    "INT",
                ],
                "date" => [
                    "TIMESTAMP(4)",
                ],
                "FOREIGN KEY (<setting_id>) REFERENCES " . $prefix . "_setting(id) ON DELETE CASCADE",
            ], ["ENGINE" => "InnoDB"]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    /**
     * save
     * save .setting file
     * all changes will be saved automaticly but user can call this function if autosave is false
     * @return bool
     * @access public
     */
    public function save()
    {
        // don't update when nothing updated or added
        if (!$this->updated && !$this->added && !count($this->updatedHitConfigs))
            return true;
        global $db;
        $setting = "";
        $valueInDb = false;
        $dbsettings = [];
        foreach ($this->data as $settingkey => $settingvalue) {
            //setting is in database
            if ($settingvalue == "STORE:DB" && isset($this->parsedata[$settingkey])) {
                if (!$valueInDb)
                    $valueInDb = true;
                $dbsettings[$settingkey] = $this->parsedata[$settingkey];
            }
            $setting .= $settingkey . '="' . addslashes($settingvalue) . "\"\n";
        }
        // update when something changed
        if ($setting != $this->rawdata) {
            file_put_contents(BASE_PATH . ".setting", $setting);
            $this->rawdata = $setting;
        }
        // insert settings that moved from local to db
        if (count($this->movedToDb)) {
            $db->insert($this->settingtablename, $this->movedToDb);
        }
        // delete settings that moved to local
        if (count($this->removedFromDb)) {
            $db->delete($this->settingtablename, ['name' => $this->removedFromDb]);
        }
        if ($valueInDb) {
            //update the db values
            foreach ($dbsettings as $settingkey => $settingvalue) {
                try {
                    $stringvalue = $this->castTypeToString($settingvalue);
                } catch (Exception $e) {
                    //value is invalid
                    continue;
                }
                $exists = $db->has($this->settingtablename, [
                    "name" => $settingkey
                ]);
                if ($exists)
                    $db->update($this->settingtablename, [
                        "data" => $stringvalue,
                    ], [
                        "name" => $settingkey
                    ]);
                else
                    $db->insert($this->settingtablename, ["name" => $settingkey, "data" => $stringvalue]);
            }
        }
        if (count($this->updatedHitConfigs)) {
            foreach ($this->updatedHitConfigs as $settingkey) {
                $db->update($this->settingtablename, [
                    "hitable" => $this->dbHitData[$settingkey]['hitable'],
                    "hitconfig" => !is_null($this->dbHitData[$settingkey]['hitconfig']) ? json_encode($this->dbHitData[$settingkey]['hitconfig']) : null,
                ], [
                    "name" => $settingkey
                ]);
                //hitable is converted to normal setting so delete the hit data
                if (isset($this->dbHitData[$settingkey]['deleteconfig']) && $this->dbHitData[$settingkey]['deleteconfig'] === true)
                    unset($this->dbHitData[$settingkey]);
                //hitable is added on runtime and doesn't have id
                if (isset($this->dbHitData[$settingkey]) && !isset($this->dbHitData[$settingkey]['id'])) {
                    $id = $db->get($this->settingtablename, "id", [
                        "name" => $settingkey
                    ]);
                    $this->dbHitData[$settingkey]['id'] = $id;
                }
            }
        }
        $this->movedToDb = $this->removedFromDb = $this->updatedHitConfigs = [];
        $this->updated = $this->added = false;
        return true;
    }
    /**
     * abortActions
     * abort update or added setting save
     * @return void
     * @access public
     */
    public function abortActions()
    {
        $this->movedToDb = $this->removedFromDb = $this->updatedHitConfigs = [];
        $this->updated = $this->added = false;
        return true;
    }
    /**
     * cleanformat
     * clean setting format and apply anit xss if needed
     * * aniti xss will be applied "one" time if there is no xss found in the settings
     * @return void
     * @access private
     */
    private function cleanformat()
    {
        global $db;
        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1") {
            $antiXss = new AntiXSS();
            $foundxss = false;
        }
        $valueInDb = false;
        $valueInDbList = [];
        foreach ($this->data as $settingkey => $settingvalue) {
            // setting value is stored in database
            if ($settingvalue == "STORE:DB") {
                if (!$valueInDb)
                    $valueInDb = true;
                $valueInDbList[] = $settingkey;
                continue;
            }
            # xss protect
            if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1") {
                $value = $antiXss->xss_clean(stripslashes($settingvalue));
                //check if there is any xss in the setting
                if (!$foundxss && $antiXss->isXssFound())
                    $foundxss = true;
            } else {
                $value = stripslashes($settingvalue);
            }
            $this->parsedata[$settingkey] =  $this->castToType($value);
        }
        if ($valueInDb) {
            $valueInDbFound = [];
            // there is some settings in database
            $dbdata = $db->select($this->settingtablename, "*", ["name" => $valueInDbList]);
            foreach ($dbdata as $settingdata) {
                # xss protect
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1") {
                    $value = $antiXss->xss_clean(stripslashes($settingdata['data']));
                    //check if there is any xss in the setting
                    if (!$foundxss && $antiXss->isXssFound())
                        $foundxss = true;
                } else {
                    $value = stripslashes($settingdata['data']);
                }
                $this->parsedata[$settingdata['name']] =  $this->castToType($value);
                //save hit data
                $this->dbHitData[$settingdata['name']] = ['id' => $settingdata['id'], 'hitable' => (bool) $settingdata['hitable'], 'hitconfig' => is_null($settingdata['hitconfig']) ? false : json_decode($settingdata['hitconfig'], true)];
                $valueInDbFound[] = $settingdata['name'];
            }
            //value is not exists in database
            $valueNotFoundInDb = array_diff($valueInDbList, $valueInDbFound);
            foreach ($valueNotFoundInDb as $notfoundkey)
                unset($this->parsedata[$notfoundkey], $this->data[$notfoundkey]);
        }
        // there is no xss no need to check again for performance
        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1" && !$foundxss) {
            $this->data['xss_clean_setting'] = "0";
            $this->updated = true;
            $this->save();
        }
    }
    /**
     * is_hitable
     * check if setting key is hitable
     * @param  string $key
     * @return bool
     * @access public
     */
    public function is_hitable($key)
    {
        return isset($this->dbHitData[$key]) && $this->dbHitData[$key]['hitable'] === true;
    }
    /**
     * is_hitable_need_update
     * check if hitable setting need update
     * @param  string $key
     * @return bool|null true or false based if need update , null if setting key is not hitable
     * @access public
     */
    public function is_hitable_need_update($key)
    {
        if ($this->is_hitable($key))
            return isset($this->dbHitData[$key]['hitconfig']['nextupdate']) && $this->dbHitData[$key]['hitconfig']['nextupdate'] <= time();
        return null;
    }
    /**
     * get_hitable_config
     * get setting key hitable config
     * @param  string $key
     * @return array|bool
     * @access public
     */
    public function get_hitable_config($key)
    {
        if ($this->is_hitable($key))
            return isset($this->dbHitData[$key]['hitconfig']) && is_array($this->dbHitData[$key]['hitconfig']) ? $this->dbHitData[$key]['hitconfig'] : false;
        return false;
    }
    /**
     * is_function_valid
     * check if function or class method exists and valid
     * @param  string|array $function function name string or array of classname and method
     * @return bool
     * @access public
     * @static
     */
    public static function is_function_valid($function)
    {
        return ((is_string($function) && function_exists($function)) || (is_array($function) && isset($function[0], $function[1]) && is_string($function[1]) && method_exists($function[0], $function[1])));
    }
    /**
     * castToType
     * cast string to type if needed
     * @param  mixed $value
     * @return array|string|int|float|bool
     * @access public
     * @static
     */
    public static function castToType($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        // integer
        if (preg_match('/^-?\d+$/', $value)) {
            return intval($value);
        }
        // float
        if (preg_match('/^-?\d+\.\d+$/', $value)) {
            return round(floatval($value), 3);
        }
        $dataserialized = @unserialize($value);
        //serialized value
        if ($dataserialized !== false || $value === 'b:0;') {
            return $dataserialized;
        }
        // json value
        $datajson = json_decode($value, true);
        if (is_array($datajson))
            return $datajson;
        //boolean value
        if ($value == "true" || $value == "false")
            return $value == "true" ? true : false;

        return $value;
    }
    /**
     * castTypeToString
     * convert array or boolean values to string
     * @throws Exception if $value type is not valid (object , class , etc)
     * @param  mixed $value
     * @param  bool $serialize serialize array or object or use json encode
     * @return string|bool string value on success or false on fail
     * @access public
     * @static
     */
    public static function castTypeToString($value, $serialize = false)
    {
        if (is_bool($value))
            return $value ? "true" : "false";
        if (is_array($value))
            return $serialize ? serialize($value) : json_encode($value);
        if (is_string($value) || is_numeric($value))
            return  is_double($value) || is_float($value) ? (string) round($value, 3) : (string) $value;
        else
            throw new Exception("value type is not valid");
        return false;
    }
    /**
     * is_modified
     * check if value is modified
     * @param  mixed $value
     * @return bool true if value is modified
     * @access public
     * @static
     */
    public static function is_modified($value)
    {
        return is_string($value) && substr($value, 0, 9) == "modified:";
    }
}
/* decelare some functions for easier use */
/**
 * addSetting
 * add new setting option (multiple add supported)
 * * recommended to always use "database" location for storing values that are updating rapidly
 * * for using bluk mode $value array keys must be same as $key both length and name otherwise $value will be considered as single array value and will be applied to all keys
 * @param  string $key setting key
 * @param  mixed $value setting value | STORE:MOVE for moving save location
 * @param  string|null $modifier modifier function name
 * @param  string|array $location store location | "local" or "database" 
 * @param  bool $serialize serialize array or object values or use json_encode
 * @param  array $hitconfig hitable setting config
 * example :
 * <code>
 * $settinghitconfig = [
 *  "minupdaterate" => "1minute",
 *  "collectfunction" => false,
 *  "deletehitsaftercollect" => true,
 * ];
 * </code>
 * config info:
 *   + minupdaterate :  minimum update rate after that hit data will be collected from database and setting key will update  (datetime)
 *      - - examples : 1second,1minute,1hour 
 *      - - default : 1minute
 *   + collectfunction : function that run when hits are collected and sat into the setting table  (callable)
 *      - - examples : [$this, "functionname"],["classname", "functionname"],"functioname"
 *      + args : accepts 5 args
 *          - - $settingkey : hitable setting key
 *          - - $hitcount : number of hits after last update
 *          - - $settingvalue : setting value
 *          - - $classrefrence : refrence to setting class
 *   + deletehitsaftercollect : keep the hit records in database or delete hits after update is done and collectfunction is called  (bool)
 * * hitable config is only available when setting key location is database
 * * in bluk add mode hitconfig will be refrenced with setting key
 * @return bool return the true on success
 */
function addSetting($key, $value, $modifier = null, $location = "local", $serialize = false, $hitconfig = [])
{
    global $settinginstance;
    return $settinginstance->add($key, $value, $modifier, $location, $serialize, $hitconfig);
}
/**
 * updateSetting
 * update setting option (multiple update supported)
 * * recommended to always use "database" location for storing values that are updating rapidly
 * * for using bluk mode $value array keys must be same as $key both length and name otherwise $value will be considered as single array value and will be applied to all keys
 * @param  string|array $key setting key
 * @param  mixed|array $value setting value | STORE:MOVE for moving save location
 * @param  string|null $modifier modifier function name
 * @param  string|array $location store location | "local" or "database" 
 * @param  bool $serialize serialize array or object values or use json_encode
 * @param  array $hitconfig hitable setting config
 * example :
 * <code>
 * $settinghitconfig = [
 *  "minupdaterate" => "1minute",
 *  "collectfunction" => false,
 *  "deletehitsaftercollect" => true,
 * ];
 * </code>
 * config info:
 *   + minupdaterate :  minimum update rate after that hit data will be collected from database and setting key will update  (datetime)
 *      - - examples : 1second,1minute,1hour 
 *      - - default : 1minute
 *   + collectfunction : function that run when hits are collected and sat into the setting table  (callable)
 *      - - examples : [$this, "functionname"],["classname", "functionname"],"functioname"
 *      + args : accepts 5 args
 *          - - $settingkey : hitable setting key
 *          - - $hitcount : number of hits after last update
 *          - - $settingvalue : setting value
 *          - - $classrefrence : refrence to setting class
 *   + deletehitsaftercollect : keep the hit records in database or delete hits after update is done and collectfunction is called  (bool)
 * * hitable config is only available when setting key location is database
 * * in bluk add mode hitconfig will be refrenced with setting key
 * @return bool return the true on success
 */
function updateSetting($key, $value, $modifier = null, $location = "local", $serialize = false, $hitconfig = [])
{
    global $settinginstance;
    return $settinginstance->update($key, $value, $modifier, $location, $serialize, $hitconfig);
}
/**
 * removeSetting
 * remove setting by key or keys (multiple remove supported)
 * @param  string|array $key setting key
 * @return void
 */
function removeSetting($key)
{
    global $settinginstance;
    return $settinginstance->remove($key);
}
/**
 * getSetting
 * - get setting value by specific key (multiple keys supported)
 * - for setting keys that are located in database none parse data will always return "STORE:DB"
 * @param  string $key setting key
 * @param  string $default default value
 * @param  string|null $modifier modifier function name ( only works when returnparse is true and if setting is modified)
 * @param  bool $returnparse retrun parse value or raw value
 * @return array|string|int|float|bool setting value
 */
function getSetting($key, $default, $returnparse = true, $modifier = null)
{
    global $settinginstance;
    return $settinginstance->get($key, $default, $returnparse, $modifier);
}
/**
 * hitSetting
 * add hits for hitable setting in setting hits table and collect it based on hitconfig in settings table to update setting based on update rate
 * @param  string $key hitable setting key
 * @return bool true on success | false when setting key not exists or is not hitable
 */
function hitSetting($key)
{
    global $settinginstance;
    return $settinginstance->hit($key);
}
/**
 * getAllSettings
 * get all settings
 * @param  bool $returnparse
 * @param  string|null $modifier modifier function name ( only works when returnparse is true and if setting is modified)
 * @return array settings
 */
function getAllSettings($returnparse = true, $modifier = null)
{
    global $settinginstance;
    return $settinginstance->get_all($returnparse, $modifier);
}
