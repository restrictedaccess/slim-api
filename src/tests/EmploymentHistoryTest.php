<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/19/2016
 * Time: 9:52 AM
 */

namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\EmploymentHistory;
use RemoteStaff\Entities\StaffHistory;


class EmploymentHistoryTest extends \PHPUnit_Framework_TestCase
{
    private $candidate;
    private $admin;

    protected function setUp()
    {
        $candidate = new Personal();
        $candidate->setUserid(119569);
        $candidate->setFirstName("Jocelyn");
        $candidate->setLastName("Gudmalin");
        $this->candidate = $candidate;

        $admin = new Admin();
        $admin->setFirstName("Honeylyn");
        $admin->setLastName("Lapidario");
        $this->admin = $admin;

    }

    // https://remotestaff.atlassian.net/browse/PORTAL-245
    public function testAddEmploymentHistoryBlank()
    {
        $employmentHistory = new EmploymentHistory();
        $employmentHistory->setCandidate($this->candidate);
        $employmentHistory->setCompanyName("Australian Business Coach");
        $employmentHistory->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory->setMonthFrom("NOV");
        $employmentHistory->setYearFrom("2016");
        $employmentHistory->setMonthTo("JAN");
        $employmentHistory->setYearTo("2016");
        $employmentHistory->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory->setBenefits("15 Vacation Leave, HMO");

        // Set candidate employment history
        $this->candidate->setEmploymentHistory($employmentHistory);


        // Start tests
        $this->assertNotEmpty("15 Vacation Leave, HMO", $employmentHistory->getBenefits());
        $this->assertNotEmpty("Australian Business Coach", $employmentHistory->getCompanyName());
        $this->assertNotEmpty("Virtual Assistant (Project-based)", $employmentHistory->getPosition());
        $this->assertNotEmpty("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000", $employmentHistory->getDescription());
        $this->assertNotEmpty(1, count($employmentHistory->getBenefits()));
    }


    public function testAddEmploymentHistory()
    {
        $employmentHistory = new EmploymentHistory();
        $employmentHistory->setCandidate($this->candidate);
        $employmentHistory->setCompanyName("Australian Business Coach");
        $employmentHistory->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory->setMonthFrom("NOV");
        $employmentHistory->setYearFrom("2016");
        $employmentHistory->setMonthTo("JAN");
        $employmentHistory->setYearTo("2016");
        $employmentHistory->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory->setBenefits("15 Vacation Leave, HMO");

        // Set candidate employment history
        $this->candidate->setEmploymentHistory($employmentHistory);

        $staffHistory = new StaffHistory();
        $staffHistory->setCandidate($this->candidate);
        $staffHistory->setChangedBy($this->admin);
        $staffHistory->setChanges("Added new employment history");

        // Start tests
        $this->assertEquals("15 Vacation Leave, HMO", $employmentHistory->getBenefits());
        $this->assertEquals("Australian Business Coach", $employmentHistory->getCompanyName());
        $this->assertEquals("Virtual Assistant (Project-based)", $employmentHistory->getPosition());
        $this->assertEquals("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000", $employmentHistory->getDescription());
        $this->assertEquals(1, count($employmentHistory->getBenefits()));
        $this->assertEquals("Added new employment history", $staffHistory->getChanges());
    }

    // https://remotestaff.atlassian.net/browse/PORTAL-245
    public function testDeleteEmploymentHistory()
    {
        $employmentHistory = new EmploymentHistory();
        $employmentHistory->setId(100);
        $employmentHistory->setCandidate($this->candidate);
        $employmentHistory->setCompanyName("Australian Business Coach");
        $employmentHistory->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory->setMonthFrom("NOV");
        $employmentHistory->setYearFrom("2016");
        $employmentHistory->setMonthTo("JAN");
        $employmentHistory->setYearTo("2016");
        $employmentHistory->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory->setBenefits("15 Vacation Leave, HMO");

        $employmentHistory1 = new EmploymentHistory();
        $employmentHistory1->setId(1010);
        $employmentHistory1->setCandidate($this->candidate);
        $employmentHistory1->setCompanyName("Australian Business Coach");
        $employmentHistory1->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory1->setMonthFrom("NOV");
        $employmentHistory1->setYearFrom("2016");
        $employmentHistory1->setMonthTo("JAN");
        $employmentHistory1->setYearTo("2016");
        $employmentHistory1->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory1->setBenefits("15 Vacation Leave, HMO");

        // Set candidate employment history
        $this->candidate->setEmploymentHistory($employmentHistory);
        $this->candidate->setEmploymentHistory($employmentHistory1);

        $history = $this->candidate->getEmploymentHistory();

        // Start tests
        $this->assertEquals(2, count($history));

        // Delete 1 employment history
        foreach ($history as $key => $value) {
            if ($value->getId() == 100) {
                unset($history[$key]);
            }
        }

        $this->assertEquals(1, count($history));
    }

    // https://remotestaff.atlassian.net/browse/PORTAL-247
    public function testUpdateEmploymentHistory()
    {
        $employmentHistory = new EmploymentHistory();
        $employmentHistory->setId(100);
        $employmentHistory->setCandidate($this->candidate);
        $employmentHistory->setCompanyName("Australian Business Coach");
        $employmentHistory->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory->setMonthFrom("NOV");
        $employmentHistory->setYearFrom("2016");
        $employmentHistory->setMonthTo("JAN");
        $employmentHistory->setYearTo("2016");
        $employmentHistory->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory->setBenefits("15 Vacation Leave, HMO");

        // Update Details
        $employmentHistory->setCompanyName("Insurance Company");
        $employmentHistory->setDescription("1. Lead generation
                                            *Database management*
                                            *Appointment setting*");
        $employmentHistory->setWorkSetup("Homebased Industry: Architecture Salary: 20,000 - 30,000");

        // Start tests
        $this->assertEquals("Insurance Company", $employmentHistory->getCompanyName());
        $this->assertEquals("1. Lead generation
                                            *Database management*
                                            *Appointment setting*", $employmentHistory->getDescription());
        $this->assertEquals("Homebased Industry: Architecture Salary: 20,000 - 30,000", $employmentHistory->getWorkSetup());
    }

    // https://remotestaff.atlassian.net/browse/PORTAL-248
    public function testMoveEmploymentHistory()
    {
        $employmentHistory = new EmploymentHistory();
        $employmentHistory->setId(100);
        $employmentHistory->setCandidate($this->candidate);
        $employmentHistory->setCompanyName("Australian Business Coach");
        $employmentHistory->setPosition("Virtual Assistant (Project-based)");
        $employmentHistory->setMonthFrom("NOV");
        $employmentHistory->setYearFrom("2016");
        $employmentHistory->setMonthTo("JAN");
        $employmentHistory->setYearTo("2016");
        $employmentHistory->setDescription("Email management
                                            Phone handling
                                            Work Setup: Officed Based
                                            Industry: Insurance
                                            Salary Grade: 15,000 
                                            Ending Salary Grade: 20,000");
        $employmentHistory->setBenefits("15 Vacation Leave, HMO");
        $employmentHistory->setColumnIndex(2);

        // Update/Move column index
        $employmentHistory->setColumnIndex(1);

        $this->assertEquals(1, $employmentHistory->getColumnIndex());
    }

}