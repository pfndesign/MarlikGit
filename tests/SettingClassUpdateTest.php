<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__FILE__) . '/../');

require_once(BASE_PATH . "includes/config.inc.php");
require_once(BASE_PATH . "db/db.php");
require_once(BASE_PATH . "includes/constants.php");
require_once(BASE_PATH . "includes/setting.inc.php");

use PHPUnit\Framework\TestCase;

if (!function_exists('samplemodifer')) {
    function samplemodifer($value, $is_modified = false, $serialize = false)
    {
        if ($is_modified)
            return $value;
        else
            return "#" . Setting::castTypeToString($value, $serialize) . "#";
    }

    function sampledemodifer($value)
    {
        return Setting::castToType(str_replace("#", "", $value));
    }
}
final class SettingClassUpdateTest extends TestCase
{
    /**
     * @dataProvider AddSettingProvider
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingLocal($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "local", $type[2]);
            addSetting($key, $value, null, "local", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected, $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected, $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    /**
     * @dataProvider AddSettingProvider
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingDatabase($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "database", $type[2]);
            addSetting($key, $value, null, "database", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    /**
     * @dataProvider AddSettingProvider 
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingWithModifier($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "local", $type[2]);
            addSetting($key, $value, "samplemodifer", "local", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null, true, "sampledemodifer"), 0.1, $typekey);
                $this->assertEqualsWithDelta("modified:" . samplemodifer((is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected), false, $serialize), $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null, true, "sampledemodifer"), 0.1, $typekey);
                $this->assertEqualsWithDelta("modified:" . samplemodifer((is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected), false, $serialize), $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    /**
     * @dataProvider AddSettingProvider 
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingWithModifierInDatabase($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "database", $type[2]);
            addSetting($key, $value, "samplemodifer", "database", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null, true, "sampledemodifer"), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null, true, "sampledemodifer"), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    /**
     * @dataProvider AddSettingProvider 
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingLocalWithModifierClass($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "local", $type[2]);
            addSetting($key, $value, [$this, "samplemodiferclass"], "local", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null, true, [$this, "sampledemodiferclass"]), 0.1, $typekey);
                $this->assertEqualsWithDelta("modified:" . samplemodifer((is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected), false, $serialize), $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null, true, [$this, "sampledemodiferclass"]), 0.1, $typekey);
                $this->assertEqualsWithDelta("modified:" . samplemodifer((is_array($expected) && isset($expected[$keyname]) ? $expected[$keyname] : $expected), false, $serialize), $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    /**
     * @dataProvider AddSettingProvider 
     * @dataProvider BulkAddSettingProvider
     */
    public function testUpdateSettingDatabaseWithModifierClass($key, $value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $types = $this->CastTypeToStringProvider();
        foreach ($types as $typekey => $type) {
            addSetting($key, $type[0], null, "database", $type[2]);
            addSetting($key, $value, [$this, "samplemodiferclass"], "database", $serialize);
            //reinit class check
            $reinitsetting = new Setting();
            if (!is_array($key))
                $key = [0 => $key];
            foreach ($key as $keyindex => $keyname) {
                //updated instance check
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $settinginstance->get($keyname, null, true, [$this, "sampledemodiferclass"]), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $settinginstance->get($keyname, null, false), 0.1, $typekey);
                $this->assertEqualsWithDelta(is_array($value) && isset($value[$keyname]) && array_values($key) == array_keys($value) ? $value[$keyname] : $value, $reinitsetting->get($keyname, null, true, [$this, "sampledemodiferclass"]), 0.1, $typekey);
                $this->assertEqualsWithDelta("STORE:DB", $reinitsetting->get($keyname, null, false), 0.1, $typekey);
                //remove it
                $settinginstance->remove($keyname);
                $reinitsetting->remove($keyname);
            }
        }
        // free memory
        unset($reinitsetting);
    }
    public function BulkAddSettingProvider(): array
    {
        $randomstring = $this->generateRandomString(5);
        $randomstring2 = $this->generateRandomString(5);
        $randomstring3 = $this->generateRandomString(5);
        $randomstring4 = $this->generateRandomString(5);
        $randomstring5 = $this->generateRandomString(5);
        $randomstring6 = $this->generateRandomString(5);
        return [
            'single int value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                1,
                "1",
                false
            ],
            'single string value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                "test",
                "test",
                false
            ],
            'single float value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                1.5,
                "1.5",
                false
            ],
            'single double value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                19.589,
                "19.589",
                false
            ],
            'single bool value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                true,
                "true",
                false
            ],
            'single array json to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}',
                false
            ],
            'single array serialize to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                'a:4:{s:3:"key";s:5:"value";s:4:"key2";a:2:{s:3:"key";i:50;s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}}s:4:"key3";a:3:{s:3:"key";s:4:"test";s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}s:4:"key3";a:2:{s:3:"key";b:0;s:4:"key2";i:69;}}s:4:"key4";b:0;}',
                true
            ],
            'bulk int value to key' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => 1, $randomstring2 => 2, $randomstring3 => 3, $randomstring4 => 4, $randomstring5 => 5],
                [$randomstring => "1", $randomstring2 => "2", $randomstring3 => "3", $randomstring4 => "4", $randomstring5 => "5"],
                false
            ],
            'bulk string value to key' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => "test1", $randomstring2 => "test2", $randomstring3 => "test3", $randomstring4 => "test4", $randomstring5 => "test5"],
                [$randomstring => "test1", $randomstring2 => "test2", $randomstring3 => "test3", $randomstring4 => "test4", $randomstring5 => "test5"],
                false
            ],
            'bulk float value to key' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => 1.5, $randomstring2 => 2.5, $randomstring3 => 4.8, $randomstring4 => 5.2, $randomstring5 => 10.8],
                [$randomstring => "1.5", $randomstring2 => "2.5", $randomstring3 => "4.8", $randomstring4 => "5.2", $randomstring5 => "10.8"],
                false
            ],
            'bulk double value to key' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => 19.589, $randomstring2 => 119.5859, $randomstring3 => 9.187, $randomstring4 => 2.58555, $randomstring5 => 122.589],
                [$randomstring => "19.589", $randomstring2 => "119.586", $randomstring3 => "9.187", $randomstring4 => "2.586", $randomstring5 => "122.589"],
                false
            ],
            'bulk double value to key2' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => true, $randomstring2 => false, $randomstring3 => false, $randomstring4 => true, $randomstring5 => false],
                [$randomstring => "true", $randomstring2 => "false", $randomstring3 => "false", $randomstring4 => "true", $randomstring5 => "false"],
                false
            ],
            'bulk mixed values to keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5, $randomstring6],
                [
                    $randomstring => 3,
                    $randomstring2 => 2.5,
                    $randomstring3 => "test2",
                    $randomstring4 => true,
                    $randomstring5 => 122.589,
                    $randomstring6 => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ]
                ],
                [
                    $randomstring => "3",
                    $randomstring2 => "2.5",
                    $randomstring3 => "test2",
                    $randomstring4 => "true",
                    $randomstring5 => "122.589",
                    $randomstring6 => '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}'
                ],
                false
            ],
            'bulk array json value to key' => [
                [$randomstring, $randomstring2],
                [
                    $randomstring => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ],
                    $randomstring2 => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ],
                ],
                [
                    $randomstring => '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}',
                    $randomstring2 => '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}'
                ],
                false
            ],
            'bulk array serialize value to key' => [
                [$randomstring3, $randomstring4],
                [
                    $randomstring3 => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ],
                    $randomstring4 => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ],
                ],
                [
                    $randomstring3 => 'a:4:{s:3:"key";s:5:"value";s:4:"key2";a:2:{s:3:"key";i:50;s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}}s:4:"key3";a:3:{s:3:"key";s:4:"test";s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}s:4:"key3";a:2:{s:3:"key";b:0;s:4:"key2";i:69;}}s:4:"key4";b:0;}',
                    $randomstring4 => 'a:4:{s:3:"key";s:5:"value";s:4:"key2";a:2:{s:3:"key";i:50;s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}}s:4:"key3";a:3:{s:3:"key";s:4:"test";s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}s:4:"key3";a:2:{s:3:"key";b:0;s:4:"key2";i:69;}}s:4:"key4";b:0;}'
                ],
                true
            ],
            'bulk mixed values to multi keys mismatch key length' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4],
                [$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true, $randomstring5 => 122.589],
                [
                    $randomstring => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true, $randomstring5 => 122.589]),
                    $randomstring2 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true, $randomstring5 => 122.589]),
                    $randomstring3 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true, $randomstring5 => 122.589]),
                    $randomstring4 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true, $randomstring5 => 122.589]),
                ],
                false
            ],
            'bulk mixed values to multi keys mismatch value length' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true],
                [
                    $randomstring => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true]),
                    $randomstring2 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true]),
                    $randomstring3 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true]),
                    $randomstring4 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true]),
                    $randomstring5 => json_encode([$randomstring => 3, $randomstring2 => 2.5, $randomstring3 => "test2", $randomstring4 => true])
                ],
                false
            ],
        ];
    }
    public function AddSettingProvider(): array
    {
        $randomstring = $this->generateRandomString(5);
        return [
            'int' => [
                $randomstring,
                1,
                "1",
                false
            ],
            'string' => [
                $randomstring,
                "test",
                "test",
                false
            ],
            'float' => [
                $randomstring,
                1.5,
                "1.5",
                false
            ],
            'double' => [
                $randomstring,
                19.589,
                "19.589",
                false
            ],
            'double2' => [
                $randomstring,
                2.58555,
                "2.586",
                false
            ],
            'double3' => [
                $randomstring,
                119.5859,
                "119.586",
                false
            ],
            'bool' => [
                $randomstring,
                true,
                "true",
                false
            ],
            'array json' => [
                $randomstring,
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}',
                false
            ],
            'array serialize' => [
                $randomstring,
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                'a:4:{s:3:"key";s:5:"value";s:4:"key2";a:2:{s:3:"key";i:50;s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}}s:4:"key3";a:3:{s:3:"key";s:4:"test";s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}s:4:"key3";a:2:{s:3:"key";b:0;s:4:"key2";i:69;}}s:4:"key4";b:0;}',
                true
            ],
        ];
    }
    public function CastTypeToStringProvider(): array
    {
        return [
            'string'  => [
                "test",
                "test",
                false
            ],
            'string to serialize'  => [
                "test",
                "test",
                true
            ],
            'int to string' => [
                1,
                "1",
                false
            ],
            'int to string serialize' => [
                1,
                "1",
                true
            ],
            'float to string' => [
                1.5,
                "1.5",
                false
            ],
            'float to string serialize' => [
                1.5,
                "1.5",
                true
            ],
            'double to string' => [
                19.589,
                "19.589",
                false
            ],
            'double2 to string' => [
                2.58555,
                "2.586",
                false
            ],
            'double3 to string' => [
                119.5859,
                "119.586",
                false
            ],
            'double to string serialize' => [
                19.589,
                "19.589",
                true
            ],
            'bool to string' => [
                true,
                "true",
                false
            ],
            'bool to string serialize' => [
                true,
                "true",
                true
            ],
            'bool2 to string' => [
                false,
                "false",
                false
            ],
            'bool2 to string serialize' => [
                false,
                "false",
                true
            ],
            'array to json' => [
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}',
                false
            ],
            'array to serialize' => [
                [
                    "key" => "value",
                    "key2" => [
                        "key" => 50,
                        "key2" => ["key" => false, "key2" => "string"]
                    ],
                    "key3" => [
                        "key" => "test",
                        "key2" => ["key" => false, "key2" => "string"],
                        "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                    ],
                    "key4" => false,
                ],
                'a:4:{s:3:"key";s:5:"value";s:4:"key2";a:2:{s:3:"key";i:50;s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}}s:4:"key3";a:3:{s:3:"key";s:4:"test";s:4:"key2";a:2:{s:3:"key";b:0;s:4:"key2";s:6:"string";}s:4:"key3";a:2:{s:3:"key";b:0;s:4:"key2";i:69;}}s:4:"key4";b:0;}',
                true
            ],
        ];
    }
    public function AddSettingBugProvider(): array
    {
        $randomstring = $this->generateRandomString(5);
        $randomstring2 = $this->generateRandomString(5);
        $randomstring3 = $this->generateRandomString(5);
        $randomstring4 = $this->generateRandomString(5);
        $randomstring5 = $this->generateRandomString(5);
        $randomstring6 = $this->generateRandomString(5);
        return [
            'bool' => [
                $randomstring,
                true,
                "true",
                false
            ],
            'single bool value to multi keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                true,
                "true",
                false
            ],
            'bulk double value to key2' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5],
                [$randomstring => true, $randomstring2 => false, $randomstring3 => false, $randomstring4 => true, $randomstring5 => false],
                [$randomstring => "true", $randomstring2 => "false", $randomstring3 => "false", $randomstring4 => "true", $randomstring5 => "false"],
                false
            ],
            'bulk mixed values to keys' => [
                [$randomstring, $randomstring2, $randomstring3, $randomstring4, $randomstring5, $randomstring6],
                [
                    $randomstring => 3,
                    $randomstring2 => 2.5,
                    $randomstring3 => "test2",
                    $randomstring4 => true,
                    $randomstring5 => 122.589,
                    $randomstring6 => [
                        "key" => "value",
                        "key2" => [
                            "key" => 50,
                            "key2" => ["key" => false, "key2" => "string"]
                        ],
                        "key3" => [
                            "key" => "test",
                            "key2" => ["key" => false, "key2" => "string"],
                            "key3" => ["key" => false, "key2" => "string", "key2" => 69]
                        ],
                        "key4" => false,
                    ]
                ],
                [
                    $randomstring => "3",
                    $randomstring2 => "2.5",
                    $randomstring3 => "test2",
                    $randomstring4 => "true",
                    $randomstring5 => "122.589",
                    $randomstring6 => '{"key":"value","key2":{"key":50,"key2":{"key":false,"key2":"string"}},"key3":{"key":"test","key2":{"key":false,"key2":"string"},"key3":{"key":false,"key2":69}},"key4":false}'
                ],
                false
            ],
        ];
    }
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function samplemodiferclass($value, $is_modified = false, $serialize = false)
    {
        if ($is_modified)
            return $value;
        else
            return "#" . Setting::castTypeToString($value, $serialize) . "#";
    }
    public static function sampledemodiferclass($value)
    {
        return Setting::castToType(str_replace("#", "", $value));
    }
}
