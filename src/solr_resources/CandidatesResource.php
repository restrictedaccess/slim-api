<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 5:51 PM
 */
namespace RemoteStaff\Solr\Resources;

use RemoteStaff\AbstractSolrResource;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\StaffRate;
use RemoteStaff\Entities\StaffTimezone;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use Solarium\Client;
use RemoteStaff\Resources\CandidateResource as MysqlCandidateResource;
use Valitron\Validator;
use Doctrine\Common\Collections\Criteria;



class CandidatesResource extends AbstractSolrResource{



    public function getSkypeIds($request){



        $result = array();
        $result["result"] = array();

        $output_data = $request["candidates"];


        $mysql_resource = new MysqlCandidateResource();

        foreach ($output_data as $key => $data) {
            $mysql_result = $mysql_resource->get($data["personal_userid"]);


            $output_data[$key]["skype"] = $mysql_result->getSkypeId();

        }

        $result["success"] = true;

        $result["result"] = $output_data;

        return $result;
    }

    /**
     * @param $request
     * @return array
     */
    public function getCategoriesCandidates($request){
        $result = array();
        $result["result"] = array();

        $output_data = $request["candidates"];


        $mysql_resource = new MysqlCandidateResource();

        foreach ($output_data as $key => $data) {


            $mysql_result = $mysql_resource->get($data["personal_userid"]);

            $categories = $mysql_result->getCategorizedEntries();


            $output_data = $this->getCategoriesNotShownASL($categories, $output_data, $key);

            $output_data = $this->getCategoriesShowASL($categories, $output_data, $key);

        }

        $result["success"] = true;

        $result["result"] = $output_data;

        return $result;
    }


    /**
     * @param $request
     * @return array
     */
    public function getStaffRateCandidates($request){
        $result = array();
        $result["result"] = array();

        $output_data = $request["candidates"];


        $mysql_resource = new MysqlCandidateResource();


        $mongo_resource = new ProductPriceResource();

        foreach ($output_data as $key => $data) {


            $mysql_result = $mysql_resource->get($data["personal_userid"]);


            $staff_rate = $mysql_result->getStaffRate();

            $output_data = $this->getStaffRate($staff_rate, $key, $output_data, $mongo_resource);

        }

        $result["success"] = true;

        $result["result"] = $output_data;

        return $result;
    }



    public function getStaffTimeZoneCandidates($request){
        $result = array();
        $result["result"] = array();

        $output_data = $request["candidates"];


        $mysql_resource = new MysqlCandidateResource();



        foreach ($output_data as $key => $data) {


            $mysql_result = $mysql_resource->get($data["personal_userid"]);


            $staff_time_zone = $mysql_result->getStaffTimezone();

            $output_data = $this->getStaffTimeZone($staff_time_zone, $key, $output_data);

        }

        $result["success"] = true;

        $result["result"] = $output_data;

        return $result;
    }

    /**
     * Create Document
     * @param $resultset
     * @param $output_data
     * @param $date_fields
     * @return array
     */
    protected function createDocument( $resultset, $output_data, $date_fields ) {

        //LOOP ALL RESULT SET
        foreach ( $resultset as $document ) {

            if( ! empty( $document[ 'personal_lname' ] ) && ! empty( $document[ 'personal_fname' ] ) ) {

                //CREATE DOCUMENT DATA STORAGE VARIABLE
                $document_data = array();

                //LOOP ALL DOCUMENT
                foreach ( $document as $field => $value ) {

                    //CHECK IF VALUE IS ARRAY
                    if ( is_array( $value ) ) {

                        $value = implode( ', ', $value );



                    }

                    //CHECK IF FIELD IS IN DATE FIELDS
                    if ( in_array( $field, $date_fields ) ) {
                        $value = date_format( new \DateTime( $value ), 'Y-m-d' );
                    }


                    //APPEND VALUE TO FIELD
                    $document_data[ $field ] = $value;

                }

                //APPEND DOCUMENT DATA TO OUTPUT DATA
                $output_data[] = $document_data;

            }

        }

        //RETURN OUTPUT DATA
        return $output_data;

    }

    /*
	*
	* FORMAT DATES
	*
	*/
    protected function formatDates( $records, $date_fields ) {

        //LOOP ALL RECORD
        foreach ( $records as $key => $values ) {

            //LOOP ALL VALUES
            foreach ( $values as $key_field => $field ) {

                //CHECK IF KEYFIELD IS IN DATE FIELDS
                if ( in_array( $key_field, $date_fields ) ) {


                    if( $key_field == "shortlisted_date" || $key_field == "endorsed_date" || $key_field == "interviewed_date" ) {

                        $processed_dates = explode( ", ", $field );

                        $records[ $key ][ $key_field ] = array();

                        foreach ($processed_dates as $key_dates => $date) {

                            $records[ $key ][ $key_field ][] = date_format( new \DateTime( $date ), "F j, Y" );

                        }

                    } else {
                        $records[ $key ][ $key_field ] = date_format( new \DateTime( $field ), "F j, Y" );
                    }

                }

            }

        }

        //RETURN RECORDS
        return $records;

    }

    /**
     * @param StaffTimezone $staff_time_zone
     * @param $key
     * @param $output_data
     * @return mixed
     */
    protected function getStaffTimeZone(StaffTimezone $staff_time_zone = null, $key, $output_data){
        if(!empty($staff_time_zone)){
            $output_data[$key]["staff_time_zone_id"] = $staff_time_zone->getId();
            $full_time_zone = $staff_time_zone->getFullTimeTimezone();
            $part_time_zone = $staff_time_zone->getPartTimeTimezone();

            $output_data[$key]["full_time_availability_time_zones"] = "";

            if(!empty($full_time_zone)){
                $exploded_full_time_zone = explode(",", $full_time_zone);
                $temp_full_time_zone = array();
                $any_found = false;
                foreach ($exploded_full_time_zone as $item) {
                    if($item != "ANY"){
                        $temp_full_time_zone[] = $item;
                    } else if($item == "ANY"){
                        $any_found = true;
                        break;
                    }
                }
                //if ANY is found the insert all
                if($any_found){
                    $temp_full_time_zone[] = "AU";
                    $temp_full_time_zone[] = "UK";
                    $temp_full_time_zone[] = "US";
                }
                $full_time_zone = implode(",", $temp_full_time_zone);
                $output_data[$key]["full_time_availability_time_zones"] = $full_time_zone;
            }


            $output_data[$key]["part_time_availability_time_zones"] = "";

            if(!empty($part_time_zone)){
                $exploded_part_time_zone = explode(",", $part_time_zone);
                $temp_part_time_zone = array();
                $any_found = false;
                foreach ($exploded_part_time_zone as $item) {
                    if($item != "ANY"){
                        $temp_part_time_zone[] = $item;
                    } else if($item == "ANY"){
                        $any_found = true;
                    }
                }

                //if ANY is found the insert all
                if($any_found){
                    $temp_part_time_zone[] = "AU";
                    $temp_part_time_zone[] = "UK";
                    $temp_part_time_zone[] = "US";
                }
                $part_time_zone = implode(",", $temp_part_time_zone);
                $output_data[$key]["part_time_availability_time_zones"] = $part_time_zone;
            }

        }

        return $output_data;
    }


    protected function getStaffRate(StaffRate $staff_rate = null, $key, $output_data, $mongo_resource){
        if(!empty($staff_rate)){
            if(!empty($staff_rate->getAdminInformation())){
                $output_data[$key]["admin_id"] = $staff_rate->getAdminInformation()->getId();
            }
            $output_data[$key]["staff_rate_id"] = $staff_rate->getId();
            $full_time_product = $staff_rate->getFullTimeRate();
            $part_time_product = $staff_rate->getPartFullTimeRate();


            if(!empty($full_time_product)){

                $output_data[$key]["full_time_product_id"] = $full_time_product->getId();
                $full_time_rate_mongo = $mongo_resource->getFullTimePrice($full_time_product->getId());

                if(!empty($full_time_rate_mongo)){
                    //echo $full_time_rate_mongo->getDetails()->last()->getAmount() . "<br />";
                    //FETCH PHP RATE START
                    $code = $full_time_rate_mongo->getCode();

                    $php_rate = str_replace("PHP-FT-", "", $code);

                    $php_rate = str_replace(",", "", $php_rate);

                    $php_rate = floatval($php_rate);

                    $php_hourly_rate = $this->getHourlyRateFullTime($php_rate);
                    //FETCH PHP RATE END


                    $details = $full_time_rate_mongo->getDetails();

                    $us_hourly_rate = null;

                    $uk_hourly_rate = null;

                    $au_hourly_rate = null;


                    foreach ($details as $detail) {
                        $current = $detail->getCurrency();
                        if($current == "USD"){
                            $us_rate = $detail->getAmount();
                            $us_rate = floatval($us_rate);
                            $us_hourly_rate = $this->getHourlyRateFullTime($us_rate);
                        } else if($current == "AUD"){
                            $au_rate = $detail->getAmount();
                            $au_rate = floatval($au_rate);
                            $au_hourly_rate = $this->getHourlyRateFullTime($au_rate);
                        } else if($current == "GBP"){
                            $uk_rate = $detail->getAmount();
                            $uk_rate = floatval($uk_rate);
                            $uk_hourly_rate = $this->getHourlyRateFullTime($uk_rate);
                        }
                    }





                    $output_data[ $key ][ 'full_time_rate_ph' ] = number_format( $php_hourly_rate , 2 , "." , "," );
                    if(!empty($us_hourly_rate)){
                        $output_data[ $key ][ 'full_time_rate_us' ] = number_format( $us_hourly_rate , 2 , "." , "," );
                    }


                    if(!empty($uk_hourly_rate)){
                        $output_data[ $key ][ 'full_time_rate_uk' ] = number_format( $uk_hourly_rate , 2 , "." , "," );
                    }


                    if(!empty($au_hourly_rate)){
                        $output_data[ $key ][ 'full_time_rate_au' ] = number_format( $au_hourly_rate , 2 , "." , "," );
                    }


                }
            }



            if(!empty($part_time_product)){
                $output_data[$key]["part_time_product_id"] = $part_time_product->getId();
                $part_time_rate_mongo = $mongo_resource->getPartTimePrice($part_time_product->getId());


                if(!empty($part_time_rate_mongo)){
                    //echo $part_time_rate_mongo->getDetails()->last()->getAmount() . "<br />";

                    //FETCH PHP RATE START
                    $code = $part_time_rate_mongo->getCode();

                    $php_rate = str_replace("PHP-PT-", "", $code);

                    $php_rate = str_replace(",", "", $php_rate);

                    $php_rate = floatval($php_rate);

                    $php_hourly_rate = $this->getHourlyRatePartTime($php_rate);
                    //FETCH PHP RATE END


                    $details = $part_time_rate_mongo->getDetails();

                    $us_hourly_rate = null;

                    $uk_hourly_rate = null;

                    $au_hourly_rate = null;


                    foreach ($details as $detail) {
                        $current = $detail->getCurrency();
                        if($current == "USD"){
                            $us_rate = $detail->getAmount();
                            $us_rate = floatval($us_rate);
                            $us_hourly_rate = $this->getHourlyRatePartTime($us_rate);
                        } else if($current == "AUD"){
                            $au_rate = $detail->getAmount();
                            $au_rate = floatval($au_rate);
                            $au_hourly_rate = $this->getHourlyRatePartTime($au_rate);
                        } else if($current == "GBP"){
                            $uk_rate = $detail->getAmount();
                            $uk_rate = floatval($uk_rate);
                            $uk_hourly_rate = $this->getHourlyRatePartTime($uk_rate);
                        }
                    }





                    $output_data[ $key ][ 'part_time_rate_ph' ] = number_format( $php_hourly_rate , 2 , "." , "," );
                    if(!empty($us_hourly_rate)){
                        $output_data[ $key ][ 'part_time_rate_us' ] = number_format( $us_hourly_rate , 2 , "." , "," );
                    }


                    if(!empty($uk_hourly_rate)){
                        $output_data[ $key ][ 'part_time_rate_uk' ] = number_format( $uk_hourly_rate , 2 , "." , "," );
                    }


                    if(!empty($au_hourly_rate)){
                        $output_data[ $key ][ 'part_time_rate_au' ] = number_format( $au_hourly_rate , 2 , "." , "," );
                    }
                }
            }

        }
        return $output_data;
    }

    /**
     * Fetch Categories not shown in ASL
     * @param $categories
     * @param $output_data
     * @param $key
     * @return mixed
     */
    protected function getCategoriesNotShownASL($categories, $output_data, $key){
        //Fetch Categories not in SHOWN in ASL
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("ratings", "1"))
            ->orderBy(array("date_created" => Criteria::DESC));

        $categoriesNotShownToASL = $categories->matching($criteria);


        if(!empty($categoriesNotShownToASL) && !isset($output_data[$key]["mongo_result"]["candidate_categorize"])){

            $output_data[$key]["mongo_result"]["candidate_categorize"] = array();
            $output_data[$key]["mongo_result"]["candidate_categorize"]["categorized_details"] = array();
        }

        foreach ($categoriesNotShownToASL as $key_categoryEntry => $categoryEntry) {
            /**
             * @var $categoryEntry CategorizedEntry
             */
            $category = $categoryEntry->getCategory();
            $sub_category = $categoryEntry->getSubCategory();

            $newEntry = array();

            $newEntry["category"]["id"] = $category->getId();
            $newEntry["category"]["name"] = $category->getCategoryName();

            $newEntry["sub_category"]["id"] = $sub_category->getId();
            $newEntry["sub_category"]["name"] = $sub_category->getSubCategoryName();

            $newEntry["categorized_id"] = $categoryEntry->getId();
            if($categoryEntry->getRecruiter()){
                $newEntry["admin_id"] = $categoryEntry->getRecruiter()->getId();
            }


            $output_data[$key]["mongo_result"]["candidate_categorize"]["categorized_details"][] = $newEntry;
        }

        return $output_data;
    }


    /**
     * Fetch Categories shown in ASL
     * @param $categories
     * @param $output_data
     * @param $key
     * @return mixed
     */
    protected function getCategoriesShowASL($categories, $output_data, $key){
        //Fetch Categories SHOWN in ASL
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("ratings", "0"))
            ->orderBy(array("date_created" => Criteria::DESC));

        $categoriesShownInASL = $categories->matching($criteria);


        if(!empty($categoriesShownInASL) && !isset($output_data[$key]["mongo_result"]["candidate_asl"])){
            $output_data[$key]["mongo_result"]["candidate_asl"] = array();
            $output_data[$key]["mongo_result"]["candidate_asl"]["categorized_details"] = array();
        }


        foreach ($categoriesShownInASL as $key_categoryEntry => $categoryEntry) {
            $category = $categoryEntry->getCategory();
            $sub_category = $categoryEntry->getSubCategory();

            $newEntry = array();

            $newEntry["category"]["id"] = $category->getId();
            $newEntry["category"]["name"] = $category->getCategoryName();

            $newEntry["sub_category"]["id"] = $sub_category->getId();
            $newEntry["sub_category"]["name"] = $sub_category->getSubCategoryName();

            $newEntry["categorized_id"] = $categoryEntry->getId();

            $output_data[$key]["mongo_result"]["candidate_asl"]["categorized_details"][] = $newEntry;
        }

        return $output_data;
    }


    protected function getHourlyRateFullTime($rate){
        $yearly_rate = $rate * 12;
        $weekly_rate = $yearly_rate / 52;
        $daily_rate = $weekly_rate / 5;
        $hourly_rate = $daily_rate / 8;

        return $hourly_rate;
    }

    protected function getHourlyRatePartTime($rate){
        $yearly_rate = $rate * 12;
        $weekly_rate = $yearly_rate / 52;
        $daily_rate = $weekly_rate / 5;
        $hourly_rate = $daily_rate / 4;

        return $hourly_rate;
    }




} 