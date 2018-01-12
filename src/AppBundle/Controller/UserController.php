<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SerialData;
use AppBundle\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Constant\Genry;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/serials", name="serials")
     */
    public function getSerials(Request $request) {

        $user = $this->getCurrentUser();

        $serials = []; //$user->getSerials();

        // replace this example code with whatever you need
        return $this->render('user/serials.html.twig', [
            'titleName' => "Мои сериалы",
            'items' => $serials,
            'genries' => Genry::getGenries(),
        ]);
    }

    /**
     * @Route("/season", name="season_page")
     */
    public function getSeasonPage(Request $request) {
        return $this->render('user/seasonPage.html.twig', [
            'titleName' => "Название сериала",
            'genries' => Genry::getGenries(),
        ]);
    }

    /**
     * @Route("/user/viewed", name="viewed")
     */
    public function getViewedSerials(Request $request) {
        // replace this example code with whatever you need
        return $this->render('user/viewed.html.twig', [
            'titleName' => "Просмотренные",
            'genries' => Genry::getGenries(),
        ]);
    }

    /**
     * @Route("/user/add", name="add_serial")
     */
    public function addSerialAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getCurrentUser();

        $em->flush();

        return new Response();
    }


    /**
     * @Route("/user/timetable", name="timetable"   )
     */
    public function getTimetable(Request $request) {
        // replace this example code with whatever you need
        return $this->render('user/timetable.html.twig', [
            'titleName' => "Расписание",
            'genries' => Genry::getGenries(),
        ]);
    }

    private function getCurrentUser() {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        return $em->getRepository(User::class)->find($id);
    }
}