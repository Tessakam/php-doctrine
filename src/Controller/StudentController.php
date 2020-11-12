<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;

    /**
     * StudentController constructor.
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/student", name="student")
     * @param Request $request
     */

    public function addStudent(Request $request)
    {
        // json_decode ( string $json [, bool $assoc = NULL [, int $depth = 512 [, int $options = 0 ]]] ) : mixed
        // getContent links with studentRepository
        $data = json_decode($request->getContent(), true, 512);
        var_dump($data);
        //json_decode($data,JSON_PRETTY_PRINT);

        $student = new Student();
        $student->setFirstName($data['firstName']);
        $student->setLastName($data['lastName']);
        $student->setEmail($data['email']);
        $student->setAddress($data['street']['streetNumber']['Zip']['city']);
        $this->getDoctrine()->getManager()->persist($student);
        $this->getDoctrine()->getManager()->flush();
    }

    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',]);

    }

}
