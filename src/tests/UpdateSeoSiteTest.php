<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/25/2016
 * Time: 1:54 PM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Documents\SiteMap;
use RemoteStaff\Documents\SiteMapHistory;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Exceptions\InvalidArgumentException;
use RemoteStaff\Mongo\Resources\SEOToolsResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;


class UpdateSeoSiteTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    private $admin;

    private $urls;
    private $histories = null;


    protected function setUp()
    {

        $this->admin = new Admin();

        $this->admin->setId("317");
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");

        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(SEOToolsResource::class);

        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-21 13:02:00");

        $this->stub
            ->expects($this->any())
            ->method('saveSite')
            ->will($this->returnCallback(function($data, $admin) use ($dateCreated){
                /**
                 * @var $admin Admin
                 */

                $result = [
                    "success" => true,
                    "state" => "add",
                    "saved_site" => array()
                ];


                if(!isset($data["link"])){
                    throw new InvalidArgumentException("Data cannot be empty!");
                }

                $state = "add";

                $site = new SiteMap();

                $old_data = [];

                if(isset($data["uri"])){
                    //$existing_site = $this->getSiteMapByUri($data["uri"]);

                    $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("uri", $data["uri"]));

                    $existing_sites = $this->urls->matching($criteria);



                    if($existing_sites->count() > 0){

                        /**
                         * @var $site SiteMap
                         */

                        foreach ($existing_sites as $existing_site) {
                            $site = $existing_site;
                        }

                        $old_data = $site->toArray();

                        $state = "update";

                    } else{
                        $site->setDateCreated(new \DateTime());
                    }

                    $site->setUri($data["uri"]);
                }



                if(isset($data["link"])){
                    $site->setLink($data["link"]);
                }


                if(isset($data["title"])){
                    $site->setTitle($data["title"]);
                }

                if(isset($data["meta_description"])){
                    $site->setMetaDescription($data["meta_description"]);
                }

                if(isset($data["meta_keywords"])){
                    $site->setMetaKeywords($data["meta_keywords"]);
                }

                if(isset($data["page_h1"])){
                    $site->setPageH1($data["page_h1"]);
                }

                if(isset($data["page_h2"])){
                    $site->setPageH2($data["page_h2"]);
                }

                if(isset($data["page_h3"])){
                    $site->setPageH3($data["page_h3"]);
                }

                if(isset($data["redirects_to"])){
                    $site->setRedirectsTo($data["redirects_to"]);
                }


                $history_changes = "Added a new site <font color=#FF0000>" . $site->getLink() . "</font> ";
                if($state == "update"){
                    foreach ($this->urls as $key => $url) {
                        if($url->getUri() == $site->getUri()){
                            $this->urls[$key] = $site;
                        }

                    }
                    $new_record = $data;
                    $old_record = $old_data;
                    $difference = array_diff_assoc($old_record,$new_record);

                    $history_changes = "Updated a site <font color=#FF0000>" . $site->getLink() . "</font><br />";


                    if( count($difference) > 0) {
                        foreach (array_keys($difference) as $array_key) {
                            if(isset($new_record[$array_key])){
                                $history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_record[$array_key], $new_record[$array_key]);
                            }
                        }
                    }
                } else{
                    $this->urls->add($site);
                }

                $history = $this->createHistory($history_changes, $admin, $dateCreated);

                $this->histories->add($history);


                $result["saved_site"] = $site->toArray();
                $result["state"] = $state;

                $result["success"] = true;



                return $result;

            }));

    }



    public function testAddSite(){

        $this->urls = new ArrayCollection();

        $this->histories = new ArrayCollection();


        $new_data = [
            "link" => "www.remotestaff.com.au/staff/login",
            "uri" => "",
            "title" => "",
            "meta_description" => "",
            "meta_keywords" => "",
            "page_h1" => "",
            "page_h2" => "",
            "page_h3" => "",
            "redirects_to" => ""
        ];

        $url_parts = parse_url($new_data["link"]);
        if(isset($url_parts["path"])){
            $new_data["uri"] = trim($url_parts["path"], "/");
        }

        $result = $this->stub->saveSite($new_data, $this->admin);

        $last_site = $this->urls->last();

        $array_to_return = [
            "urls" => $this->urls,
            "histories" => $this->histories
        ];

        $this->assertEquals(
            $last_site->getLink(),
            $result["saved_site"]["link"]
        );

        return $array_to_return;

    }


    /**
     *
     * @depends testAddSite
     * @param $array_to_return
     * @return mixed
     */
    public function testUpdateExistingSite($array_to_return){

        $this->urls = $array_to_return["urls"];

        $this->histories = $array_to_return["histories"];

        $new_data = [
            "link" => "www.remotestaff.com.au/staff/login",
            "uri" => "",
            "title" => "Test Meta Titles",
            "meta_description" => "Test Meta Description",
            "meta_keywords" => "Test Meta Keywords",
            "page_h1" => "",
            "page_h2" => "",
            "page_h3" => "",
            "redirects_to" => "remotestaff.com.au/portal/admin-login"
        ];



        $url_parts = parse_url($new_data["link"]);
        if(isset($url_parts["path"])){
            $new_data["uri"] = trim($url_parts["path"], "/");
        }


        $result = $this->stub->saveSite($new_data, $this->admin);

        $last_site = $this->urls->last();

        $this->assertEquals(
            $last_site->getTitle(),
            $new_data["title"]
        );

        return $array_to_return;
    }



    /**
     * @depends testAddSite
     * @param $array_to_return
     */
    public function testHasAddHistory($array_to_return){

        $this->urls = $array_to_return["urls"];

        $this->histories = $array_to_return["histories"];

        $last_history = $this->histories->last();


        $this->assertRegExp(
            '/to Test Meta Titles/',
            $last_history->getChanges()
        );
    }


    /**
     * @param $changes
     * @param Admin $admin
     */
    private function createHistory($changes, Admin $admin, $dateCreated = null){
        $new_history = new SiteMapHistory();

        $new_history->setChanges($changes);
        $new_history->setChangedById($admin->getId());
        $new_history->setChangedByFirstName($admin->getFirstName());
        $new_history->setChangedByLastName($admin->getLastName());
        $new_history->setChangedByFullName($admin->getFirstName() . " " . $admin->getLastName());
        $new_history->setDateCreated(new \DateTime());
        if($dateCreated != null){
            $new_history->setDateCreated($dateCreated);
        }


        $type = "HR";

        if($admin->getStatus() == "FULL-CONTROL"){
            $type = "ADMIN";
        }


        $new_history->setChangedByType($type);

        return $new_history;
    }
}