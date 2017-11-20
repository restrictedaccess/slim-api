<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 12/13/2016
 * Time: 8:26 PM
 */

namespace RemoteStaff\Resources;


use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\DefinedSkill;

class SkillResource  extends AbstractResource
{


    /**
     * @return mixed
     */
    public function getDefinedSkillsSearch($q){
        $em = $this->getEntityManager();

//        $query = $em->createQuery('SELECT s FROM RemoteStaff\Entities\DefinedSkill s WHERE s.skillName LIKE :q');
//
//        $query->setParameter('q', $q);
//
//        $skills = $query->getResult();

        $qb = $em->createQueryBuilder();

        $qb->select(array('s')) // string 'u' is converted to array internally
        ->from('RemoteStaff\Entities\DefinedSkill', 's')
            ->where(
                $qb->expr()->like('s.skillName', $qb->expr()->literal("%" . $q . "%"))
            )
            //->orderBy('s.skillName', 'ASC')
        ;
        $query = $qb->getQuery();

        $skills = $query->getResult();


        return $skills;
    }

}