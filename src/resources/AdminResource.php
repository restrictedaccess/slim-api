<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 18/08/16
 * Time: 9:25 PM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;

/**
 * Resource for Admin Data
 *
 * Class AdminResource
 * @package RemoteStaff\Resources
 */
class AdminResource extends AbstractResource{

    /**
     * @param $id
     * @return \RemoteStaff\Entities\Admin
     * @throws Exception
     */
    public function get($id){
        if ($id===null){
            throw new \Exception("Admin ID is required");
        }
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($id);
        return $admin;
    }


    /**
     * @return mixed
     */
    public function getAllRecruiters(){
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT c FROM RemoteStaff\Entities\Admin c WHERE c.status = 'HR' AND c.id != 67 ORDER BY c.firstName ASC");

        $recruiters = $query->getResult();

        return $recruiters;
    }


    /**
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public function getByEmail($email){
        if(empty($email)){
            throw new \Exception("Email is required!");
        }
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT a FROM RemoteStaff\Entities\Admin a WHERE a.status != 'REMOVED' AND a.email = :email_address");

        $query->setParameter('email_address', $email);


        $admins = $query->getResult();

        return $admins;
    }


    /**
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function getByEmailPassword($email, $password){
        if(empty($email)){
            throw new \Exception("Email is required!");
        }

        if(empty($password)){
            throw new \Exception("Password is required!");
        }

        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT a FROM RemoteStaff\Entities\Admin a WHERE a.status != 'REMOVED' AND a.email = :email_address AND a.password = :password");

        $query->setParameter('email_address', $email);

        $query->setParameter('password', sha1($password));


        $admins = $query->getResult();

        return $admins;
    }
} 