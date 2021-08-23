<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\TeacherFormType;
use App\Entity\Teacher;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\throwException;

class TeacherController extends AbstractController
{
    
     /**
      * @Route("/teacher", name="teacher_list")
      */
      public function viewAllTeacher(){
        $teachers = $this->getDoctrine()
                          ->getRepository(teacher::class)
                          ->findAll();
         return $this->render(
             "teacher/index.html.twig",
             [
                 'teachers' => $teachers
             ]
             );
    }

   /**
   * @Route("/teacher/detail/{id}", name="teacher_detail")
   */
  public function detailTeacher ($id) {
      $teacher = $this->getDoctrine()
                     ->getRepository(Teacher::class)
                     ->find($id);
   /* SQL: "SELECT * FROM Author WHERE id = '$id'" */

      if ($teacher == null) {
          $this->addFlash("Error", "teacher ID in invalid");
          return $this->redirectToRoute("teacher_list");
      }

      return $this->render(
                      "teacher/detail.html.twig",
                      [
                        'teacher' => $teacher
                      ]
      );
  }
     /**
      * @Route("/teacher/delete/{id}", name="teacher_delete")
      */
      public function deleteTeacher($id){
          $teacher = $this->getDoctrine()
                           ->getRepository(Teacher::class)
                           ->find($id);
                           if ($teacher == null) {
                              $this->addFlash("Error", "teacher ID in invalid");
                              return $this->redirectToRoute("teacher_list");
                          }
          $manager = $this->getDoctrine()
                          ->getManager();
          $manager->remove($teacher);
          $manager->flush();
          $this->addFlash("Success","teacher has been deleted");

          return $this->redirectToRoute("teacher_list");
      }
   /**
     * @Route("/teacher/create", name="teacher_create")
     */
    public function createTeacher(Request $request){
        $teacher = new Teacher();
        $form = $this->createForm(TeacherFormType::class,$teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("Success","Add teacher successfully !");
            return $this->redirectToRoute("teacher_list");
        }
        return $this->render(
            "teacher/create.html.twig",
            [
                "form" =>$form->createView()
            ]
            );
    }

  /**
  * @Route("/teacher/update/{id}", name="teacher_update")
  */
  public function updateTeacher(Request $request, $id){
       $teacher = $this->getDoctrine()
                          ->getRepository(Teacher::class)
                           ->find($id);
      $form = $this->createForm(TeacherFormType::class, $teacher);
      $form->handleRequest($request);

      if($form->isSubmitted()&& $form->isValid()){
        
          $manager = $this->getDoctrine()
                          ->getManager();
          $manager->persist($teacher);
          $manager->flush();
          $this->addFlash("info","update teacher successfull ! ");
          return $this->redirectToRoute("teacher_list");
      }

      return $this->render(
          "teacher/update.html.twig",
          [
              "form" => $form->createView()
          ]
          );
  }
}

