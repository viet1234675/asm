<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ClassroomController extends AbstractController
{
   
     /**
      * @Route("/classroom", name="classroom_list")
      */
      public function viewAllClassroom(){
          $classrooms = $this->getDoctrine()
                            ->getRepository(Classroom::class)
                            ->findAll();
           return $this->render(
               "classroom/index.html.twig",
               [
                   'classrooms' => $classrooms
               ]
               );
      }

     /**
     * @Route("/classroom/detail/{id}", name="classroom_detail")
     */
    public function detailClassroom ($id) {
        $classroom = $this->getDoctrine()
                       ->getRepository(Classroom::class)
                       ->find($id);
     /* SQL: "SELECT * FROM Author WHERE id = '$id'" */

        if ($classroom == null) {
            $this->addFlash("Error", "Classroom ID in invalid");
            return $this->redirectToRoute("classroom_list");
        }

        return $this->render(
                        "classroom/detail.html.twig",
                        [
                          'classroom' => $classroom
                        ]
        );
    }
       /**
        * @Route("/classroom/delete/{id}", name="classroom_delete")
        */
        public function deleteClassroom($id){
            $classroom = $this->getDoctrine()
                             ->getRepository(Classroom::class)
                             ->find($id);
                             if ($classroom == null) {
                                $this->addFlash("Error", "classroom ID in invalid");
                                return $this->redirectToRoute("classroom_list");
                            }


            $students =  $this->getDoctrine()
                              ->getRepository(Student::class)
                              ->find($id);
            if ($students == null){
                $this->addFlash("Error","There are students in the class");
                return $this->redirectToRoute("classroom_list");
            }
            
            
            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->remove($classroom);
            $manager->flush();
            $this->addFlash("Success","Classroom has been deleted");

            return $this->redirectToRoute("classroom_list");
        }
    /**
     * @Route("/classroom/create", name="classroom_create_cr")
     */
    public function createClassroom(Request $request){
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomFormType::class,$classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $manager = $this->getDoctrine()
                           ->getManager();
            $manager->persist($classroom);
            $manager->flush();
            $this->addFlash("Success","Add classroom successfully !");
            return $this->redirectToRoute("classroom_list");
        }
        return $this->render(
            "classroom/create.html.twig",
            [
                "form" =>$form->createView()
            ]
            );
    }

    /**
    * @Route("/classroom/update/{id}", name="classroom_update")
    */
    public function updateClassroom(Request $request, $id){
         $classroom = $this->getDoctrine()
                            ->getRepository(Classroom::class)
                             ->find($id);
        $form = $this->createForm(ClassroomFormType::class, $classroom);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            
            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->persist($classroom);
            $manager->flush();
            $this->addFlash("info","update Classroom successfull ! ");
            return $this->redirectToRoute("classroom_list");
        }

        return $this->render(
            "classroom/update.html.twig",
            [
                "form" => $form->createView()
            ]
            );
    }
}
