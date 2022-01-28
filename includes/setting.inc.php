<?php

use voku\helper\AntiXSS;

/**
 *
 * @package setting class	
 * vision setting class											
 * @version 1.0.0		
 * @author pfndesigen@gmail.com		
 */

class Setting
{
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
            $this->rawdata = file_get_contents($path, $filename);
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
     * get setting value by specific key (multiple keys supported)
     * @param  string $key setting key
     * @param  string $default default value
     * @param  bool $returnparse retrun parse value or raw value
     * @param  string $decryption decrypt function name ( only works when returnparse is true)
     * @return array|string|int|float|bool setting value
     */
    public function get($key, $default, $returnparse = true, $decryption = false)
    {
        // return spesific set of keys
        if (is_array($key)) {
            $filteredsetting = array_filter($returnparse ? $this->parsedata : $this->data, function ($settingkey) use ($key) {
                return in_array($settingkey, $key);
            }, ARRAY_FILTER_USE_KEY);
            //decryption
            if ($returnparse && count($filteredsetting) && $decryption !== false && function_exists($decryption)) {
                //xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $antiXss = new AntiXSS();
                foreach ($filteredsetting as $settingkey => $settingvalue) {
                    // if key encrypted
                    if (substr($settingvalue, 0, 8) == "encrypt:") {
                        $decryptionvalue = call_user_func($decryption, str_replace("encrypt:", "", $settingvalue));
                        //xss clean
                        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                            $cleanvalue = $antiXss->xss_clean($decryptionvalue);
                        else
                            $cleanvalue = $decryptionvalue;
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
            //decryption
            if ($decryption !== false && function_exists($decryption)) {
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $antiXss = new AntiXSS();
                // if key exist and encrypted
                if (isset($this->data[$key]) && substr($this->data[$key], 0, 8) == "encrypt:") {
                    $decryptionvalue = call_user_func($decryption, str_replace("encrypt:", "", $this->data[$key]));
                    //xss clean
                    if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                        $cleanvalue = $antiXss->xss_clean($decryptionvalue);
                    else
                        $cleanvalue = $decryptionvalue;
                    return $cleanvalue;
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
     * *note : always use "database" location for storing values that are updating rapidly
     * @param  string|array $key setting key
     * @param  mixed|array $value setting value | STORE:MOVE for moving save location
     * @param  string $encryption encrypt function name
     * @param  string|array $location store location | "local" or "database" 
     * @param  bool $serialize serialize array or object values or use json_encode
     * @param  array $hitconfig hitable setting config
     * minupdaterate="readable time", // example : 1second , 1minute , 1hour support datetime formats
     * collectfunction="functioname to call", function that run when hits are collected and sat into the setting table , accepts 5 args [$settingkey, $hitcount, $this->data, $this->parsedata, $this)]
     * deletehitsaftercollect=(bool), delete hits after collecting the result for update
     * ** also accept key matching with $key when $key is array for multiple config on bulk add
     * ***only for location database
     * @return bool return the true on success
     */
    public function add($key, $value, $encryption = false, $location = "local", $serialize = false, $hitconfig = ['test'])
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
                $value = array_fill(0, count($key), $value); // allow applying one value for multiple keys
            else
                $value = [$value];
        }
        if (!is_array($key))
            $key = [$key];

        foreach ($key as $keyindex => $keyname) {
            if (!isset($value[$keyindex]))
                continue;
            if ($encryption !== false && function_exists($encryption)) {
                $cleanvalue = "encrypt:" . call_user_func($encryption, $value);
            } else {
                // check for xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                    $cleanvalue = $antiXss->xss_clean($value[$keyindex]);
                else
                    $cleanvalue = $value[$keyindex];
                //flated value
                $castvalue = $this->castTypeToString($cleanvalue, $serialize);
            }
            // added value or updated
            if (!isset($this->data[$keyname])) {
                $this->added = true;
                //cast values
                $this->data[$keyname] = isset($location[$keyindex]) && $location[$keyindex] ==  "local" ? $castvalue : "STORE:DB";
                $this->parsedata[$keyname] = $cleanvalue;
            } else if ($value[$keyindex] == "STORE:MOVE") {
                // move setting from db to local or other way around
                if ($this->data[$keyname] == "STORE:DB" && isset($location[$keyindex]) && $location[$keyindex] ==  "local") {
                    $this->removedFromDb[] = $keyname;
                    //save the last parse value to the data
                    $this->data[$keyname] = $this->castTypeToString($this->parsedata[$keyname], $serialize);
                    $this->updated = true;
                } elseif ($this->data[$keyname] != "STORE:DB" && isset($location[$keyindex]) && $location[$keyindex] ==  "database") {
                    $this->movedToDb[] = ["name" => $keyname, "data" => $this->data[$keyname]];
                    //change the store location
                    $this->data[$keyname] = "STORE:DB";
                    $this->updated = true;
                }
            } elseif (isset($this->data[$keyname])) {
                $rawdata = isset($location[$keyindex]) && $location[$keyindex] ==  "local" ? $castvalue : "STORE:DB";
                // if values is changed update
                if ($cleanvalue != $this->parsedata[$keyname] && $this->data[$keyname] != $rawdata) {
                    $this->data[$keyname] = $rawdata;
                    $this->parsedata[$keyname] = $cleanvalue;
                    $this->updated = true;
                }
            }
            //set hit config if location is database
            if (count($hitconfig) && isset($location[$keyindex]) && $location[$keyindex] == "database") {
                $settinghitconfig = isset($hitconfig[$keyname]) ? $hitconfig[$keyname] : $hitconfig;
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
     * *note : always use "database" location for storing values that are updating rapidly
     * @param  string|array $key setting key
     * @param  mixed|array $value setting value | STORE:MOVE for moving save location
     * @param  string $encryption encrypt function name
     * @param  string|array $location store location | "local" or "database" 
     * @param  bool $serialize serialize array or object values or use json_encode
     * @param  array $hitconfig hitable setting config
     * minupdaterate="readable time", // example : 1second , 1minute , 1hour support datetime formats
     * collectfunction="functioname to call", function that run when hits are collected and sat into the setting table , accepts 5 args [$settingkey, $hitcount, $this->data, $this->parsedata, $this)]
     * deletehitsaftercollect=(bool), delete hits after collecting the result for update
     * ** also accept key matching with $key when $key is array for multiple config on bulk add
     * ***only for location database
     * @return bool return the true on success
     */
    public function update($key, $value, $encryption = false, $location = "local", $serialize = false, $hitconfig = [])
    {
        return $this->add($key, $value, $encryption, $location, $serialize, $hitconfig);
    }
    /**
     * remove
     * remove setting by key or keys (multiple remove supported)
     * @param  string|array $key setting key
     * @return void
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
            unset($this->data[$bulkkey], $this->parsedata[$bulkkey]);
        }
        $this->updated = true;
        if ($this->autosave)
            $this->save();
    }
    /**
     * hit
     * add hits for hitable setting in setting hits table and collect it based on hitconfig in settings table to update setting based on update rate
     * @param  string $key hitable setting key
     * @return bool true on success | false when setting key not exists or is not hitable
     */
    public function hit($key)
    {
        global $db;
        // first of all check if setting key exists and hitable
        if (isset($this->dbHitData[$key]) && $this->dbHitData[$key]['hitable']) {
            // is it time to collect ?
            if (isset($this->dbHitData[$key]['hitconfig']['nextupdate']) && $this->dbHitData[$key]['hitconfig']['nextupdate'] <= time()) {
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
                    $count = $db->count($this->hitstablename, [
                        //collect hits from the start of the timer to now
                        "date[<>]" => [date('Y-m-d H:i:s', strtotime("-" . $this->dbHitData[$key]['hitconfig']['minupdaterate'] . " " . date('Y-m-d H:i:s', $this->dbHitData[$key]['hitconfig']['nextupdate']))), date('Y-m-d H:i:s')],
                        "setting_id" => $this->dbHitData[$key]['id']
                    ]);
                }
                $count++;
                //function call
                if (isset($this->dbHitData[$key]['hitconfig']['collectfunction']) && function_exists($this->dbHitData[$key]['hitconfig']['collectfunction'])) {
                    //call collect function
                    $hitdata = call_user_func($this->dbHitData[$key]['hitconfig']['collectfunction'], $key, $count, $this->data, $this->parsedata, $this);
                } else {
                    // just sample counter
                    $hitdata = is_numeric($this->parsedata[$key]) ? $this->parsedata[$key] + $count : $count;
                }
                // update hit rate
                $this->dbHitData[$key]['hitconfig']['nextupdate'] = strtotime("+" . $this->dbHitData[$key]['hitconfig']['minupdaterate']);
                // set new data
                $this->data[$key] = $this->data[$key] != "STORE:DB" ? $this->castTypeToString($hitdata) : $this->data[$key];
                // check for xss
                if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1") {
                    $antiXss = new AntiXSS();
                    $cleanvalue = $antiXss->xss_clean($hitdata);
                } else {
                    $cleanvalue = $hitdata;
                }
                //flated value
                $castvalue = $this->castTypeToString($cleanvalue);
                $this->parsedata[$key] = $castvalue;
                // hit config updated
                $this->updatedHitConfigs[] = $key;
                $this->updated = true;

                if ($this->autosave)
                    $this->save();

                return true;
            } else {
                // not the time to collect just insert new record
                $db->insert($this->hitstablename, [
                    "setting_id" => $this->dbHitData[$key]['id'],
                    "date" => date('Y-m-d H:i:s')
                ]);
                return true;
            }
        } else {
            //exeption maybe
            return false;
        }
    }
    /**
     * get_all
     * get all settings
     * @param  bool $returnparse
     * @param  string $decryption decrypt function name ( only works when returnparse is true)
     * @return array settings
     */
    public function get_all($returnparse = true, $decryption = false)
    {
        if ($returnparse && $decryption !== false && function_exists($decryption)) {
            //xss
            if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1")
                $antiXss = new AntiXSS();
            //decryption
            foreach ($this->parsedata as $settingkey => $settingvalue) {
                // if key encrypted
                if (substr($this->data[$settingkey], 0, 8) == "encrypt:") {
                    $decryptionvalue = call_user_func($decryption, str_replace("encrypt:", "", $this->data[$settingkey]));
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
     */
    public function create_tables()
    {
        global $db, $prefix;
        // delete config table
        $db->drop('config'); //bug ? perfix bug
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
                    "TIMESTAMP",
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
     * @return bool
     */
    private function save()
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
            if ($settingvalue == "STORE:DB") {
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
            //need to remove hits too
        }
        if ($valueInDb) {
            //update the db values
            foreach ($dbsettings as $settingkey => $settingvalue) {
                $exists = $db->has($this->settingtablename, [
                    "name" => $settingkey
                ]);
                if ($exists)
                    $db->update($this->settingtablename, [
                        "data" => $this->castTypeToString($settingvalue),
                    ], [
                        "name" => $settingkey
                    ]);
                else
                    $db->insert($this->settingtablename, ["name" => $settingkey, "data" => $this->castTypeToString($settingvalue)]);
            }
        }
        if (count($this->updatedHitConfigs)) {
            foreach ($this->updatedHitConfigs as $settingkey) {
                $db->update($this->settingtablename, [
                    "hitable" => $this->dbHitData[$settingkey]['hitable'],
                    "hitconfig" => json_encode($this->dbHitData[$settingkey]['hitconfig']),
                ], [
                    "name" => $settingkey
                ]);
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
     * *note : aniti xss will be applied "one" time if there is no xss found in the settings
     * @return void
     */
    private function cleanformat()
    {
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
            global $db;
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
            }
        }
        // there is no xss no need to check again for performance
        if (isset($this->data['xss_clean_setting']) && $this->data['xss_clean_setting'] == "1" && !$foundxss) {
            $this->data['xss_clean_setting'] = "0";
            $this->updated = true;
            $this->save();
        }
    }
    /**
     * castToType
     * cast string to type
     * @param  mixed $value
     * @return array|string|int|float|bool
     */
    private function castToType($value)
    {
        if (is_float($value) || is_int($value) || !is_string($value)) {
            return $value;
        }
        // integer
        if (preg_match('/^-?\d+$/', $value)) {
            return intval($value);
        }
        // float
        if (preg_match('/^-?\d+\.\d+$/', $value)) {
            return floatval($value);
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
     * @param  mixed $value
     * @param  bool $serialize serialize array or object or use json encode
     * @return string
     */
    private function castTypeToString($value, $serialize = false)
    {
        if (is_bool($value))
            return $value ? "true" : "false";
        if (is_array($value) || is_object($value))
            return $serialize ? serialize($value) : json_encode($value);
        return (string) $value;
    }
}
/* Setting instance */
$settinginstance = new Setting();
/* decelare some functions for easier use */
/**
 * addSetting
 * add new setting option (multiple add supported)
 * *note : always use "database" location for storing values that are updating rapidly
 * @param  string $key setting key
 * @param  mixed $value setting value | STORE:MOVE for moving save location
 * @param  string $encryption encrypt function name
 * @param  string|array $location store location | "local" or "database" 
 * @param  bool $serialize serialize array or object values or use json_encode
 * @param  array $hitconfig hitable setting config
 * minupdaterate="readable time", // example : 1second , 1minute , 1hour support datetime formats
 * collectfunction="functioname to call", function that run when hits are collected and sat into the setting table , accepts 5 args [$settingkey, $hitcount, $this->data, $this->parsedata, $this)]
 * deletehitsaftercollect=(bool), delete hits after collecting the result for update
 * ** also accept key matching with $key when $key is array for multiple config on bulk add
 * ***only for location database
 * @return bool return the true on success
 */
function addSetting($key, $value, $encryption = false, $location = "local", $serialize = false, $hitconfig = [])
{
    global $settinginstance;
    return $settinginstance->add($key, $value, $encryption, $location, $serialize, $hitconfig);
}
/**
 * updateSetting
 * update setting option (multiple update supported)
 * *note : always use "database" location for storing values that are updating rapidly
 * @param  string|array $key setting key
 * @param  mixed|array $value setting value | STORE:MOVE for moving save location
 * @param  string $encryption encrypt function name
 * @param  string|array $location store location | "local" or "database" 
 * @param  bool $serialize serialize array or object values or use json_encode
 * @param  array $hitconfig hitable setting config
 * minupdaterate="readable time", // example : 1second , 1minute , 1hour support datetime formats
 * collectfunction="functioname to call", function that run when hits are collected and sat into the setting table , accepts 5 args [$settingkey, $hitcount, $this->data, $this->parsedata, $this)]
 * deletehitsaftercollect=(bool), delete hits after collecting the result for update
 * ** also accept key matching with $key when $key is array for multiple config on bulk add
 * ***only for location database
 * @return bool return the true on success
 */
function updateSetting($key, $value, $encryption = false, $location = "local", $serialize = false, $hitconfig = [])
{
    global $settinginstance;
    return $settinginstance->update($key, $value, $encryption, $location, $serialize, $hitconfig);
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
 * get setting value by specific key (multiple keys supported)
 * @param  string $key setting key
 * @param  string $default default value
 * @param  string $decryption decrypt function name ( only works when returnparse is true)
 * @param  bool $returnparse retrun parse value or raw value
 * @return array|string|int|float|bool setting value
 */
function getSetting($key, $default, $returnparse = true, $decryption = false)
{
    global $settinginstance;
    return $settinginstance->get($key, $default, $returnparse, $decryption);
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
 * @param  string $decryption decrypt function name ( only works when returnparse is true)
 * @return array settings
 */
function getAllSettings($returnparse = true, $decryption = false)
{
    global $settinginstance;
    return $settinginstance->get_all($returnparse, $decryption);
}

//test
// most moved to and changed to phpunit
/*
removeSetting("testdb");
addSetting('testdb', "STORE:MOVE");
addSetting('testdb', "STORE:MOVE", false, "database");
updateSetting('testdb', "updatetest", false, "database");
removeSetting('testdb');
addSetting('hitablesetting', "10", false, "database", false, [
    'minupdaterate' => "1minute",
    'collectfunction' => "testfunction",
    'deletehitsaftercollect' => true
]);
addSetting('hitablesetting2', "10", false, "database", false, [
    'minupdaterate' => "1minute",
    'collectfunction' => "testfunction",
    'deletehitsaftercollect' => false
]);
function testfunction($key, $count, $data, $parsedata, $settinginstance)
{
    return (($parsedata[$key] + $count) / 100) . "K";
}
var_dump(hitSetting('hitablesetting2'));
*/
