<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/24/2016
 * Time: 5:40 PM
 */

namespace RemoteStaff\Mongo\Resources;


use RemoteStaff\AbstractMongoResource;
use RemoteStaff\Documents\SiteMap;
use RemoteStaff\Documents\SiteMapHistory;
use RemoteStaff\Entities\Admin;

class SEOToolsResource  extends AbstractMongoResource
{

    /**
     * @return mixed
     */
    public function getSiteMap(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\SiteMap');
        $query_builder->sort('sort_number', 'asc');

        $query = $query_builder->getQuery();


        $values = $query->execute();



        return $values;
    }

    /**
     * @param $uri
     * @return mixed
     */
    public function getSiteMapByUri($uri){
        $dm = $this->getDocumentManager();

        $value = $dm->createQueryBuilder('RemoteStaff\Documents\SiteMap')
            ->field('uri')->equals($uri)
            ->getQuery()
            ->getSingleResult();



        return $value;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getSiteMapById($id){
        $dm = $this->getDocumentManager();

        $value = $dm->createQueryBuilder('RemoteStaff\Documents\SiteMap')
            ->field('_id')->equals($id)
            ->getQuery()
            ->getSingleResult();



        return $value;
    }

    /**
     * @param $data
     * @param Admin $admin
     * @return array
     * @throws \Exception
     */
    public function saveSite($data, Admin $admin, $upload_csv=false){
        /**
         * link
         * uri
         * title
         * meta_description
         * meta_keywords
         * page_h1
         * page_h2
         * page_h3
         * redirects_to
         */

        $result = [
            "success" => true,
            "state" => "add",
            "saved_site" => array()
        ];


        if(!isset($data["link"])){
            throw new \Exception("link is required.");
        }

        if(!isset($data["id"])){
            if(!$upload_csv){
                $existing_site = $this->getSiteMapByUri($data["uri"]);

                if(!empty($existing_site)){
                    throw new \Exception("Site Already Exist!");
                }
            }

        }

        $state = "add";

        $site = new SiteMap();

        $old_data = [];

        if(isset($data["uri"])){
            $existing_site = $this->getSiteMapByUri($data["uri"]);

            if(isset($data["id"])){
                $existing_site = $this->getSiteMapById($data["id"]);
            }

            if(!empty($existing_site)){

                /**
                 * @var $site SiteMap
                 */

                $site = $existing_site;

                $old_data = $site->toArray();

                $state = "update";
            } else{
                $site->setDateCreated(new \DateTime());

                $site->setCreatedById($admin->getId());
                $site->setCreatedByName($admin->getFirstName() . " " . $admin->getLastName());
            }

            $site->setDateUpdated(new \DateTime());


            $site->setUri($data["uri"]);
        }

        if(!empty($admin)){
            $site->setLastUpdatedById($admin->getId());
            $site->setLastUpdatedByName($admin->getFirstName() . " " . $admin->getLastName());
        }


        $site->setSortNumber($data["sort_number"]);

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

        if(isset($data["save_params"])){
            $site->setSaveParams($data["save_params"]);
        }


        if($state == "add"){
            $site->setStatus("posted");
        } else if(isset($data["status"])){

            $site->setStatus($data["status"]);
        }


        $history_changes = "Added a new site <font color=#FF0000>" . $site->getLink() . "</font> ";
        if($state == "update"){
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
        }

        $history = $this->createHistory($history_changes, $admin);


        $this->getDocumentManager()->persist($site);

        $this->getDocumentManager()->persist($history);

        $this->getDocumentManager()->flush();

        $result["saved_site"] = $site->toArray();
        $result["state"] = $state;

        $result["success"] = true;

        return $result;

    }


    public function clear(){

        $dm = $this->getDocumentManager();
        $dm->createQueryBuilder('RemoteStaff\Documents\SiteMap')
            ->remove()
            ->getQuery()
            ->execute();
    }


    /**
     * @param $uri
     */
    public function remove($uri){

        /**
         * @var $site SiteMap
         */
        $site = $this->getSiteMapByUri($uri);


        if(!empty($site)){
            $site->setStatus("removed");
            $this->getDocumentManager()->persist($site);
            $this->getDocumentManager()->flush();
        }


    }


    /**
     * @param $changes
     * @param Admin $admin
     */
    private function createHistory($changes, Admin $admin){
        $new_history = new SiteMapHistory();

        $new_history->setChanges($changes);
        $new_history->setChangedById($admin->getId());
        $new_history->setChangedByFirstName($admin->getFirstName());
        $new_history->setChangedByLastName($admin->getLastName());
        $new_history->setChangedByFullName($admin->getFirstName() . " " . $admin->getLastName());
        $new_history->setDateCreated(new \DateTime());

        $type = "HR";

        if($admin->getStatus() == "FULL-CONTROL"){
            $type = "ADMIN";
        }


        $new_history->setChangedByType($type);

        return $new_history;
    }
}