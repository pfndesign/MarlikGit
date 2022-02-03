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
final class SettingClassFunctionsTest extends TestCase
{
    /**
     * @dataProvider CastTypeToStringProvider
     */
    public function testCastTypeToStringFunction($value, $expected, bool $serialize): void
    {
        global $settinginstance;
        $castvalue = $settinginstance::castTypeToString($value, $serialize);
        $this->assertEqualsWithDelta($expected, $castvalue, 0.1);
    }
    /**
     * @dataProvider CastTypeToStringInvalidProvider
     */
    public function testCastTypeToStringInvalidFunction($value, bool $serialize): void
    {
        global $settinginstance;
        $this->expectException(Exception::class);
        $settinginstance::castTypeToString($value, $serialize);
    }
    /**
     * @dataProvider CastTypeToStringProvider
     */
    public function testcastToTypeFunction($expected, $value, bool $serialize): void
    {
        global $settinginstance;
        $castvalue = $settinginstance::castToType($value, $serialize);
        $this->assertEqualsWithDelta($expected, $castvalue, 0.1);
    }
    /**
     * @dataProvider IsModifiedProvider
     */
    public function testIsModifiedFunction($value, $expected): void
    {
        global $settinginstance;
        $is_modified = $settinginstance::is_modified($value);
        $this->assertEqualsWithDelta($expected, $is_modified, 0.1);
    }
    /**
     * @dataProvider IsValidFunctionProvider
     */
    public function testIsFunctionValidFunction($value, $expected): void
    {
        global $settinginstance;
        $is_modified = $settinginstance::is_function_valid($value);
        $this->assertEqualsWithDelta($expected, $is_modified, 0.1);
    }
    public function IsValidFunctionProvider(): array
    {
        return [
            "function string valid" => ["samplemodifer", true],
            "function2 string valid" => ["sampledemodifer", true],
            "function class array valid" => [[$this, "samplemodiferclass"], true],
            "function2 class array valid" => [[$this, "sampledemodiferclass"], true],
            "function string invalid" => ["samplemodifers", false],
            "function2 string invalid" => ["sample", false],
            "function3 string invalid" => [true, false],
            "function4 string invalid" => ["", false],
            "function class array invalid" => [[$this], false],
            "function2 class array invalid" => [["samplemodifers"], false],
            "function3 class array invalid" => [[$this, "sampledemodiferclass2"], false],
            "function4 class array invalid" => [[$this, $this], false],
        ];
    }
    public function IsModifiedProvider(): array
    {
        return [
            "modified" => ["modified:test", true],
            "modified2" => ["modified:#test#", true],
            "not modified" => ["test", false],
            "not modified" => [1, false],
            "not modified" => [true, false],
        ];
    }
    public function CastTypeToStringInvalidProvider(): array
    {
        $object = new stdClass;
        $object->test = "value";
        return [
            'object' => [$object, true],
            'class' => [new Setting(), true],
            'null' => [null, true],
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
