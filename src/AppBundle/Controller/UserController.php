<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\lng\Message;
use Doctrine\DBAL\Types\IntegerType;
use AppBundle\Constant\TwigPath;
use AppBundle\Constant\Consts;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Controller\DefaultController;
use AppBundle\Controller\SerialController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends DefaultController
{
    public function __construct()
    {
        $this->serialController = new SerialController();
    }

    /**
     * @Route("/serials", name="serials")
     */
    public function getSerials(Request $request)
    {
        $history = $this->getCurrentUserHistory();
        $serialsData = $history->getSerialData()->getValues();

        $param = [
            Consts::TITLE_PARAM => Message::MY_SERIALS_TITLE,
            Consts::ITEMS_PARAM => $serialsData,
        ];

        return $this->getResponseByParameters(TwigPath::SERIALS_VIEW, $param);
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function showSettings(Request $request) // TODO
    {
        return $this->getResponseByParameters(TwigPath::SETTINGS, [Consts::TITLE_PARAM => Message::SETTINGS_TITLE]);
    }

    /**
     * @Route("/season/{id}", name="season_page", requirements={"id" = "\d+"})
     */
    public function getSeasonPage(Request $request, $id)
    {
        $season = $this->getDoctrine()->getRepository(User\UserSeason::class)->find($id);

        $title = $season->getSerialData()->getTitle();
        $param = [
            Consts::TITLE_PARAM => $title,
            Consts::SEASON_INFO_PARAM => $season,
        ];

        return $this->getResponseByParameters(TwigPath::SEASON_VIEW, $param);
    }

    /**
     * @Route("/series", name="update_state_series")
     */
    public function updateViewedSeriesState(Request $request)
    {
        $id = $request->request->get(Consts::ID);
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
    public function getViewedSerials(Request $request)
    {
        $history = $this->getCurrentUserHistory();
        $serialsData = $history->getSerialData()->getValues();

        $param = [
            Consts::TITLE_PARAM => Message::VIEWED_TITLE,
            Consts::ITEMS_PARAM => $serialsData
        ];
        return $this->getResponseByParameters(TwigPath::SERIALS_VIEWED, $param);
    }


    /**
     * @Route("/item/add?id={id}", name="add_serial", requirements={"id" = "\d+"})
     */
    public function addSerialAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $history = $this->getCurrentUserHistory();

        $serialData = $this->serialController->createUserSerialData($id, $em);
        $serialData->setHistory($history);
        $history->addSerialDatum($serialData);

        $em->flush();

        return $this->redirectToRoute('itempage', array(Consts::ID => $id));
    }

    /**
     * @Route("/item/remove?id={id}", name="remove_serial", requirements={"id" = "\d+"})
     */
    public function removeSerialAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $history = $this->getCurrentUserHistory();
        $serialData = $this->serialController->removeData($id, $em);
        $history->removeSerialDatum($serialData);
        $em->flush();

        return $this->redirectToRoute('itempage', array(Consts::ID => $id));
    }

    /**
     * @Route("/user/timetable", name="timetable")
     */
    public function getTimetable(Request $request)
    {
        return $this->getResponseByParameters(TwigPath::TIMETABLE, [Consts::TITLE_PARAM => Message::TIMETABLE_TITLE]);
    }
}