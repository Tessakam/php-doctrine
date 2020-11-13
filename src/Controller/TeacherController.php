<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher", name="teacher", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */

    private TeacherRepository $teacherRepository;

    /**
     * TeacherController constructor.
     * @param TeacherRepository $teacherRepository
     */
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function add(Request $request): JsonResponse
    {
        // json_decode ( string $json [, bool $assoc = NULL [, int $depth = 512 [, int $options = 0 ]]] ) : mixed
        // getContent links with studentRepository
        $data = json_decode($request->getContent(), true, 512);

        //embedded address
        $address = new Address($data['address']['street'], $data['address']['streetNumber'], $data['address']['zip'], $data['address']['zipcode']);

        $teacher = new teacher();
        $teacher->setFirstName($data['firstName']);
        $teacher->setLastName($data['lastName']);
        $teacher->setEmail($data['email']);
        $teacher->setAddress($address);
        $this->getDoctrine()->getManager()->persist($teacher);
        $this->getDoctrine()->getManager()->flush();

        $message = "Congrats! Teacher added!";
        return new JsonResponse($message);

        //var_dump(json_decode($data));
        //json_decode($data,JSON_PRETTY_PRINT);
    }

    public function getAllTeachers(): JsonResponse
    {
        $teacherRepository = $this->getDoctrine()->getRepository(Teacher::class);
        $teachers = $teacherRepository->findAll();

        $data = []; //don't forget to define variable
        foreach ($teachers as $teacher) {
            $data[] = $teacher->toArray();
        }
        return new JsonResponse($data[]);
    }

}


