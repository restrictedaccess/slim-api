<?php

namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\EvaluationComment;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\Personal;
class EvaluationCommentResource extends AbstractResource
{


    public function create($params)

    {

        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userid"]);
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["comment_by"]);

        $insertEvalNotes = new EvaluationComment();
        $insertEvalNotes->setCandidate($candidate);
        $insertEvalNotes->setAdmin($admin);
        $insertEvalNotes->setComments($params['comments']);
        $insertEvalNotes->setCommentDate(new \DateTime());
        $insertEvalNotes->setOrdering($params['ordering']);

        $staffHistory = $this->createStaffHistory($candidate, $admin, "added a communication notes <font color=#FF0000>[NOTES].</font>");

        $this->getEntityManager()->persist($insertEvalNotes);
        $this->getEntityManager()->persist($staffHistory);
        $this->getEntityManager()->flush();

        $lastid = $insertEvalNotes->getId();
        $admin = $this->mapAdmin($admin);
        //
        //

        return [
          "lastid"=>$lastid,
          "comment_date"=>date_format($insertEvalNotes->getCommentDate(),"M dS Y, h:m:s a")
        ];
    }



    public function getEvaluationNotes($params)
     {

        if (!$params){
            return null;
        }

         $eval_notes = $this->getEntityManager()->getRepository('RemoteStaff\Entities\EvaluationComment')->findBy(["userid"=>$params['userid']],["ordering"=>"ASC"]);


          forEach($eval_notes as $eval=>$e)
          {
              $data[] = $this->convertArray($eval_notes[$eval]);
          }



         return $data;


     }



     public function deleteComments($id)
     {
         if (!$id){
             return null;
         }

         $eval_notes = $this->getEntityManager()->getRepository('RemoteStaff\Entities\EvaluationComment')->find($id);


         if (!$eval_notes) {
             throw $this->createNotFoundException(
                 'No evaluation notes found for id ' .$id
             );
         }
         else
         {


             /**
              * @var  \RemoteStaff\Entities\EvaluationComment $eval_notes
              */

             $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($eval_notes->getUserid());
             $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($eval_notes->getCommentBy());

             $staffHistory = $this->createStaffHistory($candidate, $admin, "deleted evaluation notes for candidate.");


             $this->getEntityManager()->persist($staffHistory);



             $this->getEntityManager()->remove($eval_notes);
             $this->getEntityManager()->flush();


             return true;

         }

     }



     public function updateEvaluationComments($params)
     {



         if (!$params['id']){
             return null;
         }

         $eval_notes = $this->getEntityManager()->getRepository('RemoteStaff\Entities\EvaluationComment')->find($params['id']);


         if (!$eval_notes) {
             throw $this->createNotFoundException(
                 'No evaluation notes found for id ' .$params['id']
             );
         }
         else
         {

             /**
              * @var  \RemoteStaff\Entities\EvaluationComment $eval_notes
              */
             $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($eval_notes->getUserid());
             $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($eval_notes->getCommentBy());

             if($eval_notes->getComments() != $params['comments'] ) {
                 $staffHistory = $this->createStaffHistory($candidate, $admin, "updated evaluation notes for candidate.");
                 $this->getEntityManager()->persist($staffHistory);
             }

             $eval_notes->setComments($params['comments']);
             $eval_notes->setOrdering($params['ordering']);


             $this->getEntityManager()->flush();


             return true;

         }

     }



    private function mapAdmin(Admin $admininfo){

        return ["admin_id"=>$admininfo->getId(),
            "admin_name"=>$admininfo->getName()
            ];
    }


    private function convertArray(EvaluationComment $eval){



        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($eval->getCommentBy());
        $admin_name = $this->mapAdmin($admin);

        return [
            "id"=>$eval->getId(),
            "userid"=>$eval->getUserid(),
            "comments"=>$eval->getComments(),
            "ordering"=>$eval->getOrdering(),
            "comment_date"=>date_format($eval->getCommentDate(),"M dS Y, h:m:s a"),
            "comment_by_name"=>$admin_name['admin_name'],
            "comment_by"=>$admin_name['admin_id']
        ];
    }

}
