<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserHistory;
use Doctrine\DBAL\Types\IntegerType;

use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Constant\Genry;
use AppBundle\Controller\SerialController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->serialController = new SerialController();
    }

    /**
     * @Route("/serials", name="serials")
     */
    public function getSerials(Request $request) {

        $history = $this->getCurrentUserHistory();

        $serialsData = $history->getSerialData()->getValues();

        // replace this example code with whatever you need
        return $this->render('user/serials.html.twig', [
            'titleName' => "Мои сериалы",
            'items' => $serialsData,
            'genries' => Genry::getGenries(),
        ]);
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function showSettings(Request $request) {
        $user = $this->getCurrentUser();

        return $this->render('user/userRoom.html.twig', [
            'titleName' => "Личный кабинет",
            'genries' => Genry::getGenries(),
        ]);
    }

    /**
     * @Route("/season/{id}", name="season_page", requirements={"id" = "\d+"})
     */
    public function getSeasonPage(Request $request, $id) {
        $season = $this->getDoctrine()->getRepository(User\UserSeason::class)->find($id);

        return $this->render('user/seasonPage.html.twig', [
            'titleName' => "Название сериала",
            'genries' => Genry::getGenries(),
            'season' => $season
        ]);
    }

    /**
     * @Route("/series", name="update_state_series")
     */
    public function updateViewedSeriesState(Request $request) {
        $id = $request->request->get('id');
        if ($id)
        {
            $em = $this->getDoctrine()->getManager();
            $series = $this->getDoctrine()->getRepository(User\UserSeries::class)->find($id);

            $state = !$series->getVisible();
            $series->setVisible($state);

            $em->flush();
            return new Response((int)$state);
        }

        return new Response();
    }

    /**
     * @Route("/user/viewed", name="viewed")
     */
    public function getViewedSerials(Request $request) {
        $history = $this->getCurrentUserHistory();

        $serialsData = $history->getSerialData()->getValues();

        return $this->render('user/viewed.html.twig', [
            'titleName' => "Просмотренные",
            'genries' => Genry::getGenries(),
            'items' => $serialsData
        ]);
    }


    /**
     * @Route("/item/add?id={id}", name="add_serial", requirements={"id" = "\d+"})
     */
    public function addSerialAction($id) {
        $em = $this->getDoctrine()->getManager();

        $history = $this->getCurrentUserHistory();

        $serialData = $this->serialController->createUserSerialData($id, $em);
        $serialData->setHistory($history);
        $history->addSerialDatum($serialData);

        $em->flush();

        return $this->redirectToRoute('itempage', array("id" => $id));
    }

    /**
     * @Route("/item/remove?id={id}", name="remove_serial", requirements={"id" = "\d+"})
     */
    public function removeSerialAction($id) {
        $em = $this->getDoctrine()->getManager();

        $history = $this->getCurrentUserHistory();
        $serialData = $this->serialController->removeData($id, $em);
        $history->removeSerialDatum($serialData);
        $em->flush();

        return $this->redirectToRoute('itempage', array("id" => $id));
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

    private function getCurrentUserHistory() {
        $user = $this->getCurrentUser();
        return $this->getDoctrine()->getRepository(UserHistory::class)->findOneBy(['user' => $user->getId()]);
    }
}