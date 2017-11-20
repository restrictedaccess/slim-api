<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/5/2016
 * Time: 6:42 PM
 */

namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Product;
use RemoteStaff\Entities\Evaluation;
use RemoteStaff\Entities\EmployeeCurrentProfile;

/**
 * This class is used to test adding of candidate availability
 * Class AvailabilityTest
 * @package RemoteStaff\Tests
 */

class AvailabilityTest extends \PHPUnit_Framework_TestCase
{
    private $fullTimeRate;
    private $partTimeRate;
    private $isFullTimeYes;
    private $isPartTimeYes;
    private $codeSetValue;
    private $availableStatus;

    protected function setUp(){

        $fullTime = new Product();
        $fullTime->setId(999);
        $fullTime->setCode("PHP-FT-144,500.00");
        $fullTime->setName("Filipino Staff Full Time Rate");
        $this->fullTimeRate = $fullTime->getId();

        $partTime = new Product();
        $partTime->setId(1210);
        $partTime->setCode("PHP-PT-100,000.00");
        $partTime->setName("Filipino Staff Part Time Rate");
        $this->partTimeRate = $partTime->getId();

        $checkWorkMode = new Evaluation();
        $checkWorkMode->setWorkFulltime("yes");
        $checkWorkMode->setWorkParttime("yes");

        $setAvailableStatus = new EmployeeCurrentProfile();
        $setAvailableStatus->setAvailableStatus("Work Immediately");

        $this->availableStatus = $setAvailableStatus->getAvailableStatus();
        $this->isFullTimeYes = $checkWorkMode->getWorkFulltime();
        $this->isPartTimeYes = $checkWorkMode->getWorkParttime();

        $this->codeSetValue = $fullTime->getCode();
    }

    /*Test Cycle #2*/
    public function testIsFullTimeYes(){
        $isWorkModeFullTimeYes = $this->isFullTimeYes;
        $this->assertEquals("yes", $isWorkModeFullTimeYes);
    }

    public function testIsPartTimeYes(){
        $isWorkModePartTimeYes = $this->isPartTimeYes;
        $this->assertEquals("yes", $isWorkModePartTimeYes);
    }

    /*Test Cycle #3*/

    public function testSetCheckftullTimeRate(){
        $fullTimeRate = $this->fullTimeRate;
        $this->assertEquals(999, $fullTimeRate);
    }

    public function testSetCheckpartTimeRate(){
        $partTimeRate = $this->partTimeRate;
        $this->assertEquals(1210, $partTimeRate);
    }

    /*Test Cycle #4*/
    /**
     * @depends testIsFullTimeYes
     */
    public function testCheckIfWorkModeNotEmpty(){
        $checkWorkModeYesOpt = $this->isFullTimeYes;
        $this->assertEquals("yes", $checkWorkModeYesOpt);
    }

    /*Test Cycle #6*/
    public function testSetCodeValue(){
        $codeValue = $this->codeSetValue;
        $this->assertEquals("PHP-FT-144,500.00", $codeValue);
    }

    /*Test Cycle #7*/
    public function testAvailableStatus(){
        $status = $this->availableStatus;
        $this->assertEquals("Work Immediately", $status);
    }

}