<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__FILE__) . '/../');

require_once(BASE_PATH . "includes/config.inc.php");
require_once(BASE_PATH . "db/db.php");
require_once(BASE_PATH . "includes/constants.php");
require_once(BASE_PATH . "includes/setting.inc.php");

use PHPUnit\Framework\TestCase;

if (!function_exists('collectfuntionclass')) {
    function collectfuntionclass($settingkey, $count, $data, $settinginstance)
    {
        return (intval(str_replace("K", "", $data)) + $count) . "K";
    }
}
final class SettingClassHitTest extends TestCase
{
    public function testHitNotExistSetting(): void
    {
        $this->expectException(Exception::class);
        hitSetting("notexistkey");
    }
    public function testHitANotHitableSettingLocal(): void
    {
        $this->expectException(Exception::class);
        addSetting("nothitablesetting", "test");
        hitSetting("nothitablesetting");
        removeSetting("nothitablesetting");
    }
    public function testHitANotHitableSettingDatabase(): void
    {
        global $settinginstance;
        $this->expectException(Exception::class);
        addSetting("nothitablesetting", "test", null, "database");
        hitSetting("nothitablesetting");
        removeSetting("nothitablesetting");
    }
    /**
     * @dataProvider HitSettingProvider
     */
    public function testHitSetting($minupdaterate, $collectfunction, $deletehitsaftercollect, $hitcount, $expected, $sleep): void
    {
        global $settinginstance;
        $settinghitconfig = [
            "minupdaterate" => $minupdaterate,
            "collectfunction" => $collectfunction,
            "deletehitsaftercollect" => $deletehitsaftercollect,
        ];
        addSetting("hitable", 0, null, "database", false, $settinghitconfig);
        for ($i = 0; $i < ($hitcount - 1); $i++) {
            hitSetting("hitable");
        }
        sleep($sleep);
        hitSetting("hitable");
        $this->assertEqualsWithDelta($expected, $settinginstance->get("hitable", 0), 0.1);
        if ($deletehitsaftercollect)
            $this->assertEqualsWithDelta(0, $settinginstance->hitable_database_count("hitable"), 0.1);
        else
            $this->assertTrue($settinginstance->hitable_database_count("hitable") > 0);
        $reinitsetting = new Setting();
        $this->assertEqualsWithDelta($expected, $reinitsetting->get("hitable", 0), 0.1);
        if ($deletehitsaftercollect)
            $this->assertEqualsWithDelta(0, $reinitsetting->hitable_database_count("hitable"), 0.1);
        else
            $this->assertTrue($reinitsetting->hitable_database_count("hitable") > 0);

        $settinginstance->remove("hitable");
        $reinitsetting->remove("hitable");
    }
    /**
     * @dataProvider HitSettingProvider
     */
    public function testHitSettingDeleteHitsAfterCollect($minupdaterate, $collectfunction, $deletehitsaftercollect, $hitcount, $expected, $sleep): void
    {
        global $settinginstance;
        $settinghitconfig = [
            "minupdaterate" => $minupdaterate,
            "collectfunction" => $collectfunction,
            "deletehitsaftercollect" => false,
        ];
        addSetting("hitable", 0, null, "database", false, $settinghitconfig);
        $hitcyle = 2;
        for ($i = 0; $i < $hitcyle; $i++) {
            $startdatefrom = date('Y-m-d H:i:s.') . preg_replace("/^.*\./i", "", microtime(true));
            for ($i2 = 0; $i2 < ($hitcount - 1); $i2++) {
                hitSetting("hitable");
            }
            sleep($sleep);
            hitSetting("hitable");
            $startdateto = date('Y-m-d H:i:s.') . preg_replace("/^.*\./i", "", microtime(true));
            $this->assertEqualsWithDelta($hitcount, $settinginstance->hitable_database_count("hitable", $startdatefrom, $startdateto), 0.1, "cycle:" . $i);
            $reinitsetting = new Setting();
            $this->assertEqualsWithDelta($hitcount, $reinitsetting->hitable_database_count("hitable", $startdatefrom, $startdateto), 0.1, "cycle:" . $i);
        }
        $this->assertEqualsWithDelta(($hitcyle * $hitcount), $reinitsetting->hitable_database_count("hitable"), 0.1);
        $settinginstance->remove("hitable");
        $reinitsetting->remove("hitable");
    }
    public function HitSettingProvider(): array
    {
        return [
            '10 seconds' => [
                "10seconds",
                false,
                true,
                10,
                10,
                10
            ],
            '5 seconds' => [
                "5seconds",
                false,
                true,
                20,
                20,
                5
            ],
            '12 seconds don\'t delete after collect' => [
                "12seconds",
                false,
                false,
                25,
                25,
                12
            ],
            '15 seconds with collectfunction Class' => [
                "15seconds",
                [$this, "collectfuntionclass"],
                true,
                25,
                $this->collectfuntionclass("", 25, null, null, null),
                15
            ],
            '7 seconds with collectfunction' => [
                "7seconds",
                "collectfuntionclass",
                true,
                55,
                collectfuntionclass("", 55, null, null, null),
                7
            ],
        ];
    }
    public static function collectfuntionclass($settingkey, $count, $data, $settinginstance)
    {
        return (intval(str_replace("K", "", $data)) + $count) . "K";
    }
}
