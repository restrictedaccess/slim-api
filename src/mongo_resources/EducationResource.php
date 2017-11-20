<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 1:41 PM
 */

namespace RemoteStaff\Mongo\Resources;


use RemoteStaff\AbstractMongoResource;

class EducationResource extends AbstractMongoResource
{


    /**
     * @return mixed
     */
    public function getAllLanguages(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\Language');

        $query = $query_builder->getQuery();

        $values = $query->execute();



        return $values;
    }
    /**
     * @return mixed
     */
    public function getAllLevels(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\EducationLevels');

        $query = $query_builder->getQuery();

        $levels = $query->execute();



        return $levels;
    }


    /**
     * @return mixed
     */
    public function getAllFieldStudies(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\FieldStudy');

        $query = $query_builder->getQuery();

        $values = $query->execute();



        return $values;
    }


    /**
     * @return mixed
     */
    public function getAllCountries(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\Country');

        $query = $query_builder->getQuery();

        $values = $query->execute();



        return $values;
    }


    /**
     * @return mixed
     */
    public function getAllIndustries(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\Industry');

        $query = $query_builder->getQuery();

        $values = $query->execute();



        return $values;
    }
}