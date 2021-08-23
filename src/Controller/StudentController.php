<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\StudentFormType;
use App\Entity\Student;
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

class StudentController extends AbstractController
{
    
     /**
      * @Route("/student", name="student_list")
      */
      public function viewAllStudent(){
        $students = $this->getDoctrine()
                          ->getRepository(student::class)
                          ->findAll();
         return $this->render(
             "student/index.html.twig",
             [
                 'students' => $students
             ]
             );
    }

   /**
   * @Route("/student/detail/{id}", name="student_detail")
   */
  public function detailStudent ($id) {
      $student = $this->getDoctrine()
                     ->getRepository(Student::class)
                     ->find($id);
   /* SQL: "SELECT * FROM Author WHERE id = '$id'" */

      if ($student == null) {
          $this->addFlash("Error", "student ID in invalid");
          return $this->redirectToRoute("student_list");
      }

      return $this->render(
                      "student/detail.html.twig",
                      [
                        'student' => $student
                      ]
      );
  }
     /**
      * @Route("/student/delete/{id}", name="student_delete")
      */
      public function deleteStudent($id){
          $student = $this->getDoctrine()
                           ->getRepository(Student::class)
                           ->find($id);
                           if ($student == null) {
                              $this->addFlash("Error", "student ID in invalid");
                              return $this->redirectToRoute("student_list");
                          }
          $manager = $this->getDoctrine()
                          ->getManager();
          $manager->remove($student);
          $manager->flush();
          $this->addFlash("Success","student has been deleted");

          return $this->redirectToRoute("student_list");
      }
   /**
     * @Route("/student/create", name="student_create")
     */
    public function createStudent(Request $request){
        $student = new Student();
        $form = $this->createForm(StudentFormType::class,$student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $student->getPhoto();

            $fileName = md5(uniqid());

            $fileExtension = $photo->guessExtension();

            $photoName = $fileName . '.' . $fileExtension;
            try {
                   $photo->move(
                       $this->getParameter('student_photo'),$photoName
                   );
            }catch(FileException $e){
                throwException($e);
            }
            $student->setPhoto($photoName);

            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success","Add student successfully !");
            return $this->redirectToRoute("student_list");
        }
        return $this->render(
            "student/create.html.twig",
            [
                "form" =>$form->createView()
            ]
            );
    }

  /**
  * @Route("/student/update/{id}", name="student_update")
  */
  public function updateStudent(Request $request, $id){
       $student = $this->getDoctrine()
                          ->getRepository(Student::class)
                           ->find($id);
      $form = $this->createForm(StudentFormType::class, $student);
      $form->handleRequest($request);

      if($form->isSubmitted()&& $form->isValid()){
        $uploadedFile = $form['Photo']->getData();
        if ($uploadedFile != null) {
           
            $photo = $student->getPhoto();

            $fileName = md5(uniqid());

            $fileExtension = $photo->guessExtension();

            $photoName = $fileName . '.' . $fileExtension;
            try {
                   $photo->move(
                       $this->getParameter('student_photo'),$photoName
                   );
            }catch(FileException $e){
                throwException($e);
            }
            $student->setPhoto($photoName);
        }
          $manager = $this->getDoctrine()
                          ->getManager();
          $manager->persist($student);
          $manager->flush();
          $this->addFlash("info","update student successfull ! ");
          return $this->redirectToRoute("student_list");
      }

      return $this->render(
          "student/update.html.twig",
          [
              "form" => $form->createView()
          ]
          );
  }
}
