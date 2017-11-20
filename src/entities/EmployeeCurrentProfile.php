<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 18/08/16
 * Time: 7:11 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class EmployeeCurrentProfile
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="currentjob")
 */
class EmployeeCurrentProfile
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="integer", name="userid")
     */
    private $userid;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="employeeCurrentProfile", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var string
     * @Column(type="string", name="latest_job_title")
     */
    private $latestJobTitle;

    /**
     * @var string
     * @Column(type="string", name="available_status")
     */
    private $availableStatus;

    /**
     * @var string
     * @Column(type="integer", name="available_notice")
     */
    private $availableNotice;

    /**
     * @var string
     * @Column(type="integer", name="aday")
     */
    private $aDay;

    /**
     * @var string
     * @Column(type="string", name="amonth")
     */
    private $aMonth;

    /**
     * @var string
     * @Column(type="string", name="ayear")
     */
    private $aYear;

    /**
     * @var string
     * @Column(type="string", name="salary_currency")
     */
    private $salaryCurrency;

    /**
     * @var string
     * @Column(type="string", name="expected_salary")
     */
    private $expectedSalary;

    /**
     * @var string
     * @Column(type="string", name="expected_salary_neg")
     */
    private $expectedSalaryNeg;

    /**
     * @var string
     * @Column(type="string", name="companyname")
     */
    private $companyName;

    /**
     * @var string
     * @Column(type="string", name="position")
     */
    private $position;

    /**
     * @var string
     * @Column(type="string", name="monthfrom")
     */
    private $monthFrom;

    /**
     * @var string
     * @Column(type="string", name="yearfrom")
     */
    private $yearFrom;

    /**
     * @var string
     * @Column(type="string", name="monthto")
     */
    private $monthTo;

    /**
     * @var string
     * @Column(type="string", name="yearto")
     */
    private $yearTo;

    /**
     * @var text
     * @Column(type="text", name="duties")
     */
    private $duties;

    /**
     * @var string
     * @Column(type="string", name="companyname2")
     */
    private $companyName2;

    /**
     * @var string
     * @Column(type="string", name="position2")
     */
    private $position2;

    /**
     * @var string
     * @Column(type="string", name="monthfrom2")
     */
    private $monthFrom2;

    /**
     * @var string
     * @Column(type="string", name="yearfrom2")
     */
    private $yearFrom2;

    /**
     * @var string
     * @Column(type="string", name="monthto2")
     */
    private $monthTo2;

    /**
     * @var string
     * @Column(type="string", name="yearto2")
     */
    private $yearTo2;

    /**
     * @var text
     * @Column(type="text", name="duties2")
     */
    private $duties2;

    /**
     * @var string
     * @Column(type="string", name="companyname3")
     */
    private $companyName3;

    /**
     * @var string
     * @Column(type="string", name="position3")
     */
    private $position3;

    /**
     * @var string
     * @Column(type="string", name="monthfrom3")
     */
    private $monthFrom3;

    /**
     * @var string
     * @Column(type="string", name="yearfrom3")
     */
    private $yearFrom3;

    /**
     * @var string
     * @Column(type="string", name="monthto3")
     */
    private $monthTo3;

    /**
     * @var string
     * @Column(type="string", name="yearto3")
     */
    private $yearTo3;

    /**
     * @var text
     * @Column(type="text", name="duties3")
     */
    private $duties3;

    /**
     * @var string
     * @Column(type="string", name="companyname4")
     */
    private $companyName4;

    /**
     * @var string
     * @Column(type="string", name="position4")
     */
    private $position4;

    /**
     * @var string
     * @Column(type="string", name="monthfrom4")
     */
    private $monthFrom4;

    /**
     * @var string
     * @Column(type="string", name="yearfrom4")
     */
    private $yearFrom4;

    /**
     * @var string
     * @Column(type="string", name="monthto4")
     */
    private $monthTo4;

    /**
     * @var string
     * @Column(type="string", name="yearto4")
     */
    private $yearTo4;

    /**
     * @var text
     * @Column(type="text", name="duties4")
     */
    private $duties4;

    /**
     * @var string
     * @Column(type="string", name="companyname5")
     */
    private $companyName5;

    /**
     * @var string
     * @Column(type="string", name="position5")
     */
    private $position5;

    /**
     * @var string
     * @Column(type="string", name="monthfrom5")
     */
    private $monthFrom5;

    /**
     * @var string
     * @Column(type="string", name="yearfrom5")
     */
    private $yearFrom5;

    /**
     * @var string
     * @Column(type="string", name="monthto5")
     */
    private $monthTo5;

    /**
     * @var string
     * @Column(type="string", name="yearto5")
     */
    private $yearTo5;

    /**
     * @var text
     * @Column(type="text", name="duties5")
     */
    private $duties5;

    /**
     * @var string
     * @Column(type="string", name="companyname6")
     */
    private $companyName6;

    /**
     * @var string
     * @Column(type="string", name="position6")
     */
    private $position6;

    /**
     * @var string
     * @Column(type="string", name="monthfrom6")
     */
    private $monthFrom6;

    /**
     * @var string
     * @Column(type="string", name="yearfrom6")
     */
    private $yearFrom6;

    /**
     * @var string
     * @Column(type="string", name="monthto6")
     */
    private $monthTo6;

    /**
     * @var string
     * @Column(type="string", name="yearto6")
     */
    private $yearTo6;

    /**
     * @var text
     * @Column(type="text", name="duties6")
     */
    private $duties6;

    /**
     * @var string
     * @Column(type="string", name="companyname7")
     */
    private $companyName7;

    /**
     * @var string
     * @Column(type="string", name="position7")
     */
    private $position7;

    /**
     * @var string
     * @Column(type="string", name="monthfrom7")
     */
    private $monthFrom7;

    /**
     * @var string
     * @Column(type="string", name="yearfrom7")
     */
    private $yearFrom7;

    /**
     * @var string
     * @Column(type="string", name="monthto7")
     */
    private $monthTo7;

    /**
     * @var string
     * @Column(type="string", name="yearto7")
     */
    private $yearTo7;

    /**
     * @var text
     * @Column(type="text", name="duties7")
     */
    private $duties7;

    /**
     * @var string
     * @Column(type="string", name="companyname8")
     */
    private $companyName8;

    /**
     * @var string
     * @Column(type="string", name="position8")
     */
    private $position8;

    /**
     * @var string
     * @Column(type="string", name="monthfrom8")
     */
    private $monthFrom8;

    /**
     * @var string
     * @Column(type="string", name="yearfrom8")
     */
    private $yearFrom8;

    /**
     * @var string
     * @Column(type="string", name="monthto8")
     */
    private $monthTo8;

    /**
     * @var string
     * @Column(type="string", name="yearto8")
     */
    private $yearTo8;

    /**
     * @var text
     * @Column(type="text", name="duties8")
     */
    private $duties8;

    /**
     * @var string
     * @Column(type="string", name="companyname9")
     */
    private $companyName9;

    /**
     * @var string
     * @Column(type="string", name="position9")
     */
    private $position9;

    /**
     * @var string
     * @Column(type="string", name="monthfrom9")
     */
    private $monthFrom9;

    /**
     * @var string
     * @Column(type="string", name="yearfrom9")
     */
    private $yearFrom9;

    /**
     * @var string
     * @Column(type="string", name="monthto9")
     */
    private $monthTo9;

    /**
     * @var string
     * @Column(type="string", name="yearto9")
     */
    private $yearTo9;

    /**
     * @var text
     * @Column(type="text", name="duties9")
     */
    private $duties9;

    /**
     * @var string
     * @Column(type="string", name="companyname10")
     */
    private $companyName10;

    /**
     * @var string
     * @Column(type="string", name="position10")
     */
    private $position10;

    /**
     * @var string
     * @Column(type="string", name="monthfrom10")
     */
    private $monthFrom10;

    /**
     * @var string
     * @Column(type="string", name="yearfrom10")
     */
    private $yearFrom10;

    /**
     * @var string
     * @Column(type="string", name="monthto10")
     */
    private $monthTo10;

    /**
     * @return string
     */
    public function getCompanyName6()
    {
        return $this->companyName6;
    }

    /**
     * @param string $companyName6
     */
    public function setCompanyName6($companyName6)
    {
        $this->companyName6 = $companyName6;
    }

    /**
     * @return string
     */
    public function getPosition6()
    {
        return $this->position6;
    }

    /**
     * @param string $position6
     */
    public function setPosition6($position6)
    {
        $this->position6 = $position6;
    }

    /**
     * @return string
     */
    public function getMonthFrom6()
    {
        return $this->monthFrom6;
    }

    /**
     * @param string $monthFrom6
     */
    public function setMonthFrom6($monthFrom6)
    {
        $this->monthFrom6 = $monthFrom6;
    }

    /**
     * @return string
     */
    public function getYearFrom6()
    {
        return $this->yearFrom6;
    }

    /**
     * @param string $yearFrom6
     */
    public function setYearFrom6($yearFrom6)
    {
        $this->yearFrom6 = $yearFrom6;
    }

    /**
     * @return string
     */
    public function getMonthTo6()
    {
        return $this->monthTo6;
    }

    /**
     * @param string $monthTo6
     */
    public function setMonthTo6($monthTo6)
    {
        $this->monthTo6 = $monthTo6;
    }

    /**
     * @return string
     */
    public function getYearTo6()
    {
        return $this->yearTo6;
    }

    /**
     * @param string $yearTo6
     */
    public function setYearTo6($yearTo6)
    {
        $this->yearTo6 = $yearTo6;
    }

    /**
     * @return text
     */
    public function getDuties6()
    {
        return $this->duties6;
    }

    /**
     * @param text $duties6
     */
    public function setDuties6($duties6)
    {
        $this->duties6 = $duties6;
    }

    /**
     * @return string
     */
    public function getCompanyName7()
    {
        return $this->companyName7;
    }

    /**
     * @param string $companyName7
     */
    public function setCompanyName7($companyName7)
    {
        $this->companyName7 = $companyName7;
    }

    /**
     * @return string
     */
    public function getPosition7()
    {
        return $this->position7;
    }

    /**
     * @param string $position7
     */
    public function setPosition7($position7)
    {
        $this->position7 = $position7;
    }

    /**
     * @return string
     */
    public function getMonthFrom7()
    {
        return $this->monthFrom7;
    }

    /**
     * @param string $monthFrom7
     */
    public function setMonthFrom7($monthFrom7)
    {
        $this->monthFrom7 = $monthFrom7;
    }

    /**
     * @return string
     */
    public function getYearFrom7()
    {
        return $this->yearFrom7;
    }

    /**
     * @param string $yearFrom7
     */
    public function setYearFrom7($yearFrom7)
    {
        $this->yearFrom7 = $yearFrom7;
    }

    /**
     * @return string
     */
    public function getMonthTo7()
    {
        return $this->monthTo7;
    }

    /**
     * @param string $monthTo7
     */
    public function setMonthTo7($monthTo7)
    {
        $this->monthTo7 = $monthTo7;
    }

    /**
     * @return string
     */
    public function getYearTo7()
    {
        return $this->yearTo7;
    }

    /**
     * @param string $yearTo7
     */
    public function setYearTo7($yearTo7)
    {
        $this->yearTo7 = $yearTo7;
    }

    /**
     * @return text
     */
    public function getDuties7()
    {
        return $this->duties7;
    }

    /**
     * @param text $duties7
     */
    public function setDuties7($duties7)
    {
        $this->duties7 = $duties7;
    }

    /**
     * @return string
     */
    public function getCompanyName8()
    {
        return $this->companyName8;
    }

    /**
     * @param string $companyName8
     */
    public function setCompanyName8($companyName8)
    {
        $this->companyName8 = $companyName8;
    }

    /**
     * @return string
     */
    public function getPosition8()
    {
        return $this->position8;
    }

    /**
     * @param string $position8
     */
    public function setPosition8($position8)
    {
        $this->position8 = $position8;
    }

    /**
     * @return string
     */
    public function getMonthFrom8()
    {
        return $this->monthFrom8;
    }

    /**
     * @param string $monthFrom8
     */
    public function setMonthFrom8($monthFrom8)
    {
        $this->monthFrom8 = $monthFrom8;
    }

    /**
     * @return string
     */
    public function getYearFrom8()
    {
        return $this->yearFrom8;
    }

    /**
     * @param string $yearFrom8
     */
    public function setYearFrom8($yearFrom8)
    {
        $this->yearFrom8 = $yearFrom8;
    }

    /**
     * @return string
     */
    public function getMonthTo8()
    {
        return $this->monthTo8;
    }

    /**
     * @param string $monthTo8
     */
    public function setMonthTo8($monthTo8)
    {
        $this->monthTo8 = $monthTo8;
    }

    /**
     * @return string
     */
    public function getYearTo8()
    {
        return $this->yearTo8;
    }

    /**
     * @param string $yearTo8
     */
    public function setYearTo8($yearTo8)
    {
        $this->yearTo8 = $yearTo8;
    }

    /**
     * @return text
     */
    public function getDuties8()
    {
        return $this->duties8;
    }

    /**
     * @param text $duties8
     */
    public function setDuties8($duties8)
    {
        $this->duties8 = $duties8;
    }

    /**
     * @return string
     */
    public function getCompanyName9()
    {
        return $this->companyName9;
    }

    /**
     * @param string $companyName9
     */
    public function setCompanyName9($companyName9)
    {
        $this->companyName9 = $companyName9;
    }

    /**
     * @return string
     */
    public function getPosition9()
    {
        return $this->position9;
    }

    /**
     * @param string $position9
     */
    public function setPosition9($position9)
    {
        $this->position9 = $position9;
    }

    /**
     * @return string
     */
    public function getMonthFrom9()
    {
        return $this->monthFrom9;
    }

    /**
     * @param string $monthFrom9
     */
    public function setMonthFrom9($monthFrom9)
    {
        $this->monthFrom9 = $monthFrom9;
    }

    /**
     * @return string
     */
    public function getYearFrom9()
    {
        return $this->yearFrom9;
    }

    /**
     * @param string $yearFrom9
     */
    public function setYearFrom9($yearFrom9)
    {
        $this->yearFrom9 = $yearFrom9;
    }

    /**
     * @return string
     */
    public function getMonthTo9()
    {
        return $this->monthTo9;
    }

    /**
     * @param string $monthTo9
     */
    public function setMonthTo9($monthTo9)
    {
        $this->monthTo9 = $monthTo9;
    }

    /**
     * @return string
     */
    public function getYearTo9()
    {
        return $this->yearTo9;
    }

    /**
     * @param string $yearTo9
     */
    public function setYearTo9($yearTo9)
    {
        $this->yearTo9 = $yearTo9;
    }

    /**
     * @return text
     */
    public function getDuties9()
    {
        return $this->duties9;
    }

    /**
     * @param text $duties9
     */
    public function setDuties9($duties9)
    {
        $this->duties9 = $duties9;
    }

    /**
     * @return string
     */
    public function getCompanyName10()
    {
        return $this->companyName10;
    }

    /**
     * @param string $companyName10
     */
    public function setCompanyName10($companyName10)
    {
        $this->companyName10 = $companyName10;
    }

    /**
     * @return string
     */
    public function getPosition10()
    {
        return $this->position10;
    }

    /**
     * @param string $position10
     */
    public function setPosition10($position10)
    {
        $this->position10 = $position10;
    }

    /**
     * @return string
     */
    public function getMonthFrom10()
    {
        return $this->monthFrom10;
    }

    /**
     * @param string $monthFrom10
     */
    public function setMonthFrom10($monthFrom10)
    {
        $this->monthFrom10 = $monthFrom10;
    }

    /**
     * @return string
     */
    public function getYearFrom10()
    {
        return $this->yearFrom10;
    }

    /**
     * @param string $yearFrom10
     */
    public function setYearFrom10($yearFrom10)
    {
        $this->yearFrom10 = $yearFrom10;
    }

    /**
     * @return string
     */
    public function getMonthTo10()
    {
        return $this->monthTo10;
    }

    /**
     * @param string $monthTo10
     */
    public function setMonthTo10($monthTo10)
    {
        $this->monthTo10 = $monthTo10;
    }

    /**
     * @return string
     */
    public function getYearTo10()
    {
        return $this->yearTo10;
    }

    /**
     * @param string $yearTo10
     */
    public function setYearTo10($yearTo10)
    {
        $this->yearTo10 = $yearTo10;
    }

    /**
     * @return text
     */
    public function getDuties10()
    {
        return $this->duties10;
    }

    /**
     * @param text $duties10
     */
    public function setDuties10($duties10)
    {
        $this->duties10 = $duties10;
    }

    /**
     * @var string
     * @Column(type="string", name="yearto10")
     */
    private $yearTo10;

    /**
     * @var text
     * @Column(type="text", name="duties10")
     */
    private $duties10;

    /**
     * @return Personal
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param Personal $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLatestJobTitle()
    {
        return $this->latestJobTitle;
    }

    /**
     * @param string $latestJobTitle
     */
    public function setLatestJobTitle($latestJobTitle)
    {
        $this->latestJobTitle = $latestJobTitle;
    }

    /**
     * @return string
     */
    public function getAvailableStatus()
    {
        return $this->availableStatus;
    }

    /**
     * @param string $availableStatus
     */
    public function setAvailableStatus($availableStatus)
    {
        $this->availableStatus = $availableStatus;
    }

    /**
     * @return string
     */
    public function getAvailableNotice()
    {
        return $this->availableNotice;
    }

    /**
     * @param string $availableNotice
     */
    public function setAvailableNotice($availableNotice)
    {
        $this->availableNotice = $availableNotice;
    }

    /**
     * @return string
     */
    public function getADay()
    {
        return $this->aDay;
    }

    /**
     * @param string $aDay
     */
    public function setADay($aDay)
    {
        $this->aDay = $aDay;
    }

    /**
     * @return string
     */
    public function getAMonth()
    {
        return $this->aMonth;
    }

    /**
     * @param string $aMonth
     */
    public function setAMonth($aMonth)
    {
        $this->aMonth = $aMonth;
    }

    /**
     * @return string
     */
    public function getAYear()
    {
        return $this->aYear;
    }

    /**
     * @param string $aYear
     */
    public function setAYear($aYear)
    {
        $this->aYear = $aYear;
    }

    /**
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getSalaryCurrency()
    {
        return $this->salaryCurrency;
    }

    /**
     * @param string $salaryCurrency
     */
    public function setSalaryCurrency($salaryCurrency)
    {
        $this->salaryCurrency = $salaryCurrency;
    }

    /**
     * @return string
     */
    public function getExpectedSalary()
    {
        return $this->expectedSalary;
    }

    /**
     * @param string $expectedSalary
     */
    public function setExpectedSalary($expectedSalary)
    {
        $this->expectedSalary = $expectedSalary;
    }

    /**
     * @return string
     */
    public function getExpectedSalaryNeg()
    {
        return $this->expectedSalaryNeg;
    }

    /**
     * @param string $expectedSalaryNeg
     */
    public function setExpectedSalaryNeg($expectedSalaryNeg)
    {
        $this->expectedSalaryNeg = $expectedSalaryNeg;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getMonthFrom()
    {
        return $this->monthFrom;
    }

    /**
     * @param string $monthFrom
     */
    public function setMonthFrom($monthFrom)
    {
        $this->monthFrom = $monthFrom;
    }

    /**
     * @return string
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * @param string $yearFrom
     */
    public function setYearFrom($yearFrom)
    {
        $this->yearFrom = $yearFrom;
    }

    /**
     * @return string
     */
    public function getMonthTo()
    {
        return $this->monthTo;
    }

    /**
     * @param string $monthTo
     */
    public function setMonthTo($monthTo)
    {
        $this->monthTo = $monthTo;
    }

    /**
     * @return string
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * @param string $yearTo
     */
    public function setYearTo($yearTo)
    {
        $this->yearTo = $yearTo;
    }

    /**
     * @return text
     */
    public function getDuties()
    {
        return $this->duties;
    }

    /**
     * @param text $duties
     */
    public function setDuties($duties)
    {
        $this->duties = $duties;
    }

    /**
     * @return string
     */
    public function getCompanyName2()
    {
        return $this->companyName2;
    }

    /**
     * @param string $companyName2
     */
    public function setCompanyName2($companyName2)
    {
        $this->companyName2 = $companyName2;
    }

    /**
     * @return string
     */
    public function getPosition2()
    {
        return $this->position2;
    }

    /**
     * @param string $position2
     */
    public function setPosition2($position2)
    {
        $this->position2 = $position2;
    }

    /**
     * @return string
     */
    public function getMonthFrom2()
    {
        return $this->monthFrom2;
    }

    /**
     * @param string $monthFrom2
     */
    public function setMonthFrom2($monthFrom2)
    {
        $this->monthFrom2 = $monthFrom2;
    }

    /**
     * @return string
     */
    public function getYearFrom2()
    {
        return $this->yearFrom2;
    }

    /**
     * @param string $yearFrom2
     */
    public function setYearFrom2($yearFrom2)
    {
        $this->yearFrom2 = $yearFrom2;
    }

    /**
     * @return string
     */
    public function getMonthTo2()
    {
        return $this->monthTo2;
    }

    /**
     * @param string $monthTo2
     */
    public function setMonthTo2($monthTo2)
    {
        $this->monthTo2 = $monthTo2;
    }

    /**
     * @return string
     */
    public function getYearTo2()
    {
        return $this->yearTo2;
    }

    /**
     * @return text
     */
    public function getDuties2()
    {
        return $this->duties2;
    }

    /**
     * @param text $duties2
     */
    public function setDuties2($duties2)
    {
        $this->duties2 = $duties2;
    }

    /**
     * @return string
     */
    public function getCompanyName3()
    {
        return $this->companyName3;
    }

    /**
     * @param string $companyName3
     */
    public function setCompanyName3($companyName3)
    {
        $this->companyName3 = $companyName3;
    }

    /**
     * @return string
     */
    public function getPosition3()
    {
        return $this->position3;
    }

    /**
     * @param string $position3
     */
    public function setPosition3($position3)
    {
        $this->position3 = $position3;
    }

    /**
     * @return string
     */
    public function getMonthFrom3()
    {
        return $this->monthFrom3;
    }

    /**
     * @param string $monthFrom3
     */
    public function setMonthFrom3($monthFrom3)
    {
        $this->monthFrom3 = $monthFrom3;
    }

    /**
     * @return string
     */
    public function getYearFrom3()
    {
        return $this->yearFrom3;
    }

    /**
     * @param string $yearFrom3
     */
    public function setYearFrom3($yearFrom3)
    {
        $this->yearFrom3 = $yearFrom3;
    }

    /**
     * @return string
     */
    public function getMonthTo3()
    {
        return $this->monthTo3;
    }

    /**
     * @param string $monthTo3
     */
    public function setMonthTo3($monthTo3)
    {
        $this->monthTo3 = $monthTo3;
    }

    /**
     * @return string
     */
    public function getYearTo3()
    {
        return $this->yearTo3;
    }

    /**
     * @param string $yearTo3
     */
    public function setYearTo3($yearTo3)
    {
        $this->yearTo3 = $yearTo3;
    }

    /**
     * @return text
     */
    public function getDuties3()
    {
        return $this->duties3;
    }

    /**
     * @param text $duties3
     */
    public function setDuties3($duties3)
    {
        $this->duties3 = $duties3;
    }

    /**
     * @return string
     */
    public function getCompanyName4()
    {
        return $this->companyName4;
    }

    /**
     * @param string $companyName4
     */
    public function setCompanyName4($companyName4)
    {
        $this->companyName4 = $companyName4;
    }

    /**
     * @return string
     */
    public function getPosition4()
    {
        return $this->position4;
    }

    /**
     * @param string $position4
     */
    public function setPosition4($position4)
    {
        $this->position4 = $position4;
    }

    /**
     * @return string
     */
    public function getMonthFrom4()
    {
        return $this->monthFrom4;
    }

    /**
     * @param string $monthFrom4
     */
    public function setMonthFrom4($monthFrom4)
    {
        $this->monthFrom4 = $monthFrom4;
    }

    /**
     * @return string
     */
    public function getYearFrom4()
    {
        return $this->yearFrom4;
    }

    /**
     * @param string $yearFrom4
     */
    public function setYearFrom4($yearFrom4)
    {
        $this->yearFrom4 = $yearFrom4;
    }

    /**
     * @return string
     */
    public function getMonthTo4()
    {
        return $this->monthTo4;
    }

    /**
     * @param string $monthTo4
     */
    public function setMonthTo4($monthTo4)
    {
        $this->monthTo4 = $monthTo4;
    }

    /**
     * @return string
     */
    public function getYearTo4()
    {
        return $this->yearTo4;
    }

    /**
     * @param string $yearTo4
     */
    public function setYearTo4($yearTo4)
    {
        $this->yearTo4 = $yearTo4;
    }

    /**
     * @return text
     */
    public function getDuties4()
    {
        return $this->duties4;
    }

    /**
     * @param text $duties4
     */
    public function setDuties4($duties4)
    {
        $this->duties4 = $duties4;
    }

    /**
     * @return string
     */
    public function getCompanyName5()
    {
        return $this->companyName5;
    }

    /**
     * @param string $companyName5
     */
    public function setCompanyName5($companyName5)
    {
        $this->companyName5 = $companyName5;
    }

    /**
     * @return string
     */
    public function getPosition5()
    {
        return $this->position5;
    }

    /**
     * @param string $position5
     */
    public function setPosition5($position5)
    {
        $this->position5 = $position5;
    }

    /**
     * @return string
     */
    public function getMonthFrom5()
    {
        return $this->monthFrom5;
    }

    /**
     * @param string $monthFrom5
     */
    public function setMonthFrom5($monthFrom5)
    {
        $this->monthFrom5 = $monthFrom5;
    }

    /**
     * @return string
     */
    public function getYearFrom5()
    {
        return $this->yearFrom5;
    }

    /**
     * @param string $yearFrom5
     */
    public function setYearFrom5($yearFrom5)
    {
        $this->yearFrom5 = $yearFrom5;
    }

    /**
     * @return string
     */
    public function getMonthTo5()
    {
        return $this->monthTo5;
    }

    /**
     * @param string $monthTo5
     */
    public function setMonthTo5($monthTo5)
    {
        $this->monthTo5 = $monthTo5;
    }

    /**
     * @return string
     */
    public function getYearTo5()
    {
        return $this->yearTo5;
    }

    /**
     * @param string $yearTo5
     */
    public function setYearTo5($yearTo5)
    {
        $this->yearTo5 = $yearTo5;
    }

    /**
     * @return text
     */
    public function getDuties5()
    {
        return $this->duties5;
    }

    /**
     * @param text $duties5
     */
    public function setDuties5($duties5)
    {
        $this->duties5 = $duties5;
    }

    /**
     * @param string $yearTo2
     */
    public function setYearTo2($yearTo2)
    {
        $this->yearTo2 = $yearTo2;
    }
}