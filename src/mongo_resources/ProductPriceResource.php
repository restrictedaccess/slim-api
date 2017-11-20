<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/7/2016
 * Time: 12:55 PM
 */

namespace RemoteStaff\Mongo\Resources;


use RemoteStaff\AbstractMongoResource;
use RemoteStaff\Documents\FullTimePrice;
use RemoteStaff\Documents\PartTimePrice;

class ProductPriceResource extends AbstractMongoResource
{
    /**
     * @param $product_price_id
     * @return FullTimePrice
     * @throws \Exception
     */
    public function getFullTimePrice($product_price_id){
        $dm = $this->getDocumentManager();

        if ($product_price_id===null){
            throw new \Exception("Full time product_id is required!");
        }

        $product = $dm->getRepository('RemoteStaff\Documents\FullTimePrice')->findOneBy(["id" => $product_price_id]);

        return $product;
    }


    /**
     * @param $product_price_id
     * @return PartTimePrice
     * @throws \Exception
     */
    public function getPartTimePrice($product_price_id){
        $dm = $this->getDocumentManager();

        if ($product_price_id===null){
            throw new \Exception("Part time product_id is required!");
        }

        $product = $dm->getRepository('RemoteStaff\Documents\PartTimePrice')->findOneBy(["id" => $product_price_id]);

        return $product;
    }




    public function getAllFullTimePrice(){
        $dm = $this->getDocumentManager();

        $query_builder = $dm->createQueryBuilder();


        $query_builder->find('RemoteStaff\Documents\FullTimePrice');

        $query = $query_builder->getQuery();

        $products = $query->execute();



        return $products;
    }



    public function getAllPartTimePrice(){
        $dm = $this->getDocumentManager();


        $query_builder = $dm->createQueryBuilder();

        $query_builder->find('RemoteStaff\Documents\PartTimePrice');

        $query = $query_builder->getQuery();

        $products = $query->execute();

        //$products = $dm->getRepository('RemoteStaff\Documents\PartTimePrice')->find();

        return $products;
    }




}