<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/6/2016
 * Time: 8:48 PM
 */

namespace RemoteStaff\Solr\Resources;



use RemoteStaff\Documents\FullTimePrice;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use Solarium\Client;
use RemoteStaff\Resources\CandidateResource as MysqlCandidateResource;
use Valitron\Validator;
use Doctrine\Common\Collections\Criteria;

class CategorizeCandidatesResource extends CandidatesResource
{
    /**
     * @param $request
     * @return array
     */
    public function getCandidates($request){
        $mysql_resource = new MysqlCandidateResource();
        $client = new Client($this->getSolrConfig("candidates"));
        //CREATE A PING
        $ping = $client -> createPing();

        //EXECUTE THE PING QUERY
        try {

            //GET RESULT
            $result_solr = $client -> ping( $ping );

        } catch ( Solarium\Exception $e ) {

        }

        //GET AN UPDATE QUERY INSTANCE
        $update = $client -> createUpdate();

        //GET A SELECT QUERY INTANCE
        $query = $client -> createSelect();

        //CONSTRUCT RESULT
        $result = array();

        $result[ 'success' ] = false;

        $error_message = array();


        //GET Q
        $q = $request['q'];

        //GET PAGE
        $page = $request['page'];

        //SET NUM ROW
        $num_rows = 30;


        if ( !empty( $q ) ) {

            $q = utf8_encode(trim($q));

            $v = new Validator(array("q" => $q));
            //$v->rule('required', ['first_name', 'last_name', "email", "latest_job_title", "mobile"]);
            $v->rule('email', 'q');

            //check if email
            if($v->validate()){
                $q = '"' . utf8_encode(trim($q)) . '"';
            }

            //PROCESS
            //$q = preg_replace( array( '/^\{/', '/\}$/', '/^\[/', '/\]$/', '/^\+63/', '/^\(/', '/\)$/' ), '', $q );

            //PROCESS
            //$q = utf8_encode( $q );

            //PROCESS
            //$q = "\"" . $q . "\"";

            //SET QUERY
            $query -> setQuery( $q );

        } else{
            //SET QUERY
            $query -> setQuery( '*:*' );
        }


        $date_registered_start = $request["date_registered_start"];
        $date_registered_end = $request["date_registered_end"];
        $date_updated_start = $request["date_updated_start"];
        $date_updated_end = $request["date_updated_end"];
        $recruiter_assigned_id = $request["recruiter_assigned_id"];
        $position_advertized_tracking_code = $request["position_advertized_tracking_code"];
        $sub_category_id = $request["sub_category_id"];
        $categorized_on_asl = $request["categorized_on_asl"];
        $categorized_work_availability = $request["categorized_work_availability"];
        $personal_gender = $request["categorized_gender"];
        $date_added_on_asl_start = $request["date_added_on_asl_start"];
        $date_added_on_asl_end = $request["date_added_on_asl_end"];
        $shortlisted_date_start = $request["shortlisted_date_end"];
        $shortlisted_date_end = $request["shortlisted_date_end"];
        $endorsed_date_start = $request["endorsed_date_start"];
        $endorsed_date_end = $request["endorsed_date_end"];
        $interview_date_start = $request["interview_date_start"];
        $interview_date_end = $request["interview_date_end"];
        $inactive_date_start = $request["inactive_date_start"];
        $inactive_date_end = $request["inactive_date_end"];
        $date_progress_tagged_start = $request["date_progress_tagged_start"];
        $date_progress_tagged_end = $request["date_progress_tagged_end"];

        //CHECK PAGE IF VALID
        if ($page) {

            //SET START
            $query -> setStart( $page );

            //CONSTRUCT START
            $start = ( $page - 1 ) * $num_rows;

            //OVERIDE SET START
            $query -> setStart( $start );

            //SET ROWS
            $query -> setRows( $num_rows );

        } else {

            //SET START
            $query -> setStart( 0 );

            //SET SET ROW
            $query -> setRows($num_rows);

        }

        $query->setFields(
            array(
                "personal_userid",
                "personal_fname",
                "personal_lname",
                "personal_gender",
                "personal_dateupdated",
                "personal_datecreated",
                "personal_email",
                "personal_alt_email",
                "personal_registered_email",
                "personal_image",
                "personal_voice_path",
                "recruiter_assigned_id",
                "recruiter_assigned_first_name",
                "recruiter_assigned_last_name",
                "recruiter_assigned_full_name",
                "currentjob_latest_job_title",
                "linked_job_orders",
                "candidate_progress",
                "categorized_date_added_on_asl",
                "categorized_sub_categories",
                "categorized_work_availability",
                "categorized_on_asl"
            )
        );

        //Evaluate date registered
        if(!empty($date_registered_start) && !empty($date_registered_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_registered_filter' ) -> setQuery( 'personal_datecreated:[' . date("Y-m-d", strtotime($date_registered_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($date_registered_end)) . 'T23:59:59Z]' );
        }

        //Evaluate date updated
        if(!empty($date_updated_start) && !empty($date_updated_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_updated_filter' ) -> setQuery( 'personal_dateupdated:[' . date("Y-m-d", strtotime($date_updated_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($date_updated_end)) . 'T23:59:59Z]' );
        }

        //Evaluate $recruiter_assigned_id
        if(!empty($recruiter_assigned_id)){
            if($recruiter_assigned_id == "no_recruiter"){
                //CREATE FILTER QUERY
                $query -> createFilterQuery( 'recruiter_assigned_id_filter' )
                    -> setQuery( '-recruiter_assigned_id:*' );
            } else{
                //CREATE FILTER QUERY
                $query -> createFilterQuery( 'recruiter_assigned_id_filter' )
                    -> setQuery( 'recruiter_assigned_id:' . $recruiter_assigned_id  );
            }
        }


        //Evaluate $position_advertized_tracking_code
        if(!empty($position_advertized_tracking_code)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'personal_userid_position_advertized_filter' ) -> setQuery( 'personal_userid:' . $position_advertized_tracking_code );
        }



        //Evaluate $sub_category_id
        if(!empty($sub_category_id)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'categorize_sub_category_filter' ) -> setQuery( 'categorized_sub_categories:' . $sub_category_id );
        }

        //Evaluate $categorized_on_asl
        if(!empty($categorized_on_asl)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'categorized_on_asl_filter' ) -> setQuery( 'categorized_on_asl:' . $categorized_on_asl );
        }


        //Evaluate $categorized_work_availability
        if(!empty($categorized_work_availability)){
            //CREATE FILTER QUERY
            //$query -> createFilterQuery( 'categorized_work_availability_userid_filter' ) -> setQuery( 'categorized_work_availability:' . $categorized_work_availability );
            $query -> createFilterQuery( 'categorized_work_availability_userid_filter' ) -> setQuery( "categorized_work_availability:\"$categorized_work_availability\"");
        }



        //Evaluate $personal_gender
        if(!empty($personal_gender)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'personal_gender_filter' ) -> setQuery( 'personal_gender:' . $personal_gender );
        }


        //Evaluate date updated
        if(!empty($date_added_on_asl_start) && !empty($date_added_on_asl_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_date_added_on_asl_filter' ) -> setQuery( 'categorized_date_added_on_asl:[' . date("Y-m-d", strtotime($date_added_on_asl_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($date_added_on_asl_end)) . 'T23:59:59Z]' );
        }


        //Evaluate date updated
        if(!empty($shortlisted_date_start) && !empty($shortlisted_date_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_shortlisted_date_filter' ) -> setQuery( 'personal_gender:[' . date("Y-m-d", strtotime($shortlisted_date_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($shortlisted_date_end)) . 'T23:59:59Z]' );
        }

        //Evaluate date updated
        if(!empty($endorsed_date_start) && !empty($endorsed_date_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_endorsed_date_filter' ) -> setQuery( 'personal_gender:[' . date("Y-m-d", strtotime($endorsed_date_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($endorsed_date_end)) . 'T23:59:59Z]' );
        }


        //Evaluate date updated
        if(!empty($interview_date_start) && !empty($interview_date_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_interview_date_filter' ) -> setQuery( 'personal_gender:[' . date("Y-m-d", strtotime($interview_date_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($interview_date_end)) . 'T23:59:59Z]' );
        }

        //Evaluate date updated
        if(!empty($inactive_date_start) && !empty($inactive_date_end)){
            //CREATE FILTER QUERY
            $query -> createFilterQuery( 'date_inactive_date_filter' ) -> setQuery( 'personal_gender:[' . date("Y-m-d", strtotime($inactive_date_start)) . 'T00:00:00Z TO ' . date("Y-m-d", strtotime($inactive_date_end)) . 'T23:59:59Z]' );
        }



        //SET FILTER
        $filter = "candidate_progress:categorized";


        //CREATE FILLTER QUERY
        $query -> createFilterQuery("icategorized_candidate_progress_filter" ) -> setQuery( $filter );


        $controllerName = "categorized";

        //CREATE FILTER QUERIES
        $query -> createFilterQuery( $controllerName . '_not_inactive_filter' ) -> setQuery( '-candidate_progress:inactive' );

        $query -> createFilterQuery( $controllerName . '_not_unprocessed_filter' ) -> setQuery( '-candidate_progress:unprocessed' );

        $query -> createFilterQuery( $controllerName . '_not_remote_ready_filter' ) -> setQuery( '-candidate_progress:remote_ready' );



        //ADD SORT DATEUPDATED DESCENDING
        $query -> addSort( "personal_dateupdated", $query::SORT_DESC );



        $resultset = $client->select($query);


        //CHECK IF RESULT SET IS NOT EQUAL TO 0
        if ( $resultset -> getNumFound() > 0 ) {

            //STORE ALL DATES
            $date_fields = array('personal_dateupdated', 'personal_datecreated', 'categorized_date_added_on_asl', 'shortlisted_date', 'endorsed_date', 'interviewed_date', 'inactive_date');


            //CREATE NEW OUTPUT STORAGE VARIABLE
            $output_data = array();

            //CREATE OUTPUT DATA
            $output_data = $this->createDocument($resultset, $output_data, $date_fields);

            //OVERIDE OUTPUT DATA
            $output_data = $this->formatDates($output_data, $date_fields);

            $mongo_resource = new ProductPriceResource();


            //PROCESS OUTPUT DATA
            foreach ($output_data as $key => $data) {
                $mysql_result = $mysql_resource->get($data["personal_userid"]);



                $output_data[$key]["mongo_result"] = array();

                $output_data[$key]["personal_image"] = $mysql_result->getImage();
                $output_data[$key]["personal_voice_path"] = $mysql_result->getVoice();


                if(!empty($mysql_result->getBirthDateYear())){
                    $output_data[$key]["birthdate"] = $mysql_result->getBirthDateYear() . "-" . $mysql_result->getBirthDateMonth() . "-" . $mysql_result->getBirthDateDay();
                }

                if(!isset($output_data[$key]["recruiter_assigned_id"])){
                    $recruiter = $mysql_result->getActiveRecruiter();
                    if(!empty($recruiter)){
                        $output_data[$key]["recruiter_assigned_id"] = $recruiter->getId();
                        $output_data[$key]["recruiter_assigned_first_name"] = $recruiter->getFirstName();
                        $output_data[$key]["recruiter_assigned_last_name"] = $recruiter->getLastName();
                        $output_data[$key]["recruiter_assigned_full_name"] = $recruiter->getName();
                    }

                }


                /*
                //$evaluation = $mysql_result->getEvaluation();

                $staff_time_zone = $mysql_result->getStaffTimezone();

                $output_data = $this->getStaffTimeZone($staff_time_zone, $key, $output_data);



                $staff_rate = $mysql_result->getStaffRate();

                $output_data = $this->getStaffRate($staff_rate, $key, $output_data, $mongo_resource);
                */

                $categories = $mysql_result->getCategorizedEntries();


                $output_data = $this->getCategoriesNotShownASL($categories, $output_data, $key);

                $output_data = $this->getCategoriesShowASL($categories, $output_data, $key);


            }
            //APPEND NUM FOUND
            $result[ 'num_found' ] = $resultset -> getNumFound();

            //APPEND NUM ROWS
            $result[ 'num_rows' ] = $num_rows;

            //APPEND RESULT
            $result[ 'result' ] = $output_data;

            //APPEND SUCCESS
            $result[ 'success' ] = true;
        } else{
            //APPEND ERRORS
            $result[ 'errors' ][] = 'No records found.';

            //APPEND SUCCESS
            $result[ 'success' ] = false;
        }



        return $result;

    }





}