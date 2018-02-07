<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Serial;
use AppBundle\lng\Message;
use AppBundle\Constant\TwigPath;
use AppBundle\Constant\Consts;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use \DateTime;

class UserController extends DefaultController
{
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
     * @Route("/sendcomment", name="save_comment")
     */
    public function sendComment(Request $request)
    {
        $commentText = $request->request->get(Consts::COMMENT);
        $id = $request->request->get(Consts::ID);

        if ($commentText && $id)
        {
            $serial = $this->getDoctrine()->getRepository(Serial::class)->find($id);

            $comment = new Comment();
            $comment->setUser($this->getCurrentUser());
            $comment->setDate(new DateTime());
            $comment->setSerial($serial);
            $comment->setText($commentText);
            $serial->addComment($comment);

            $this->appendObjectToBaseData($comment);

            $data = array(
                Consts::USERNAME => $comment->getUser()->getUsername(),
                Consts::COMMENT => $commentText,
                Consts::DATE => $comment->getDate()->format("d.m.Y"),
            );
            return new JsonResponse($data);
        }
        return new Response();
    }

    /**
     * @Route("/user/viewed", name="viewed")
     */
    public function getViewedSerials(Request $request)
    {
        $history = $this->getCurrentUserHistory();
        $serials = $history->getSerialData()->getValues();

        $this->updateSerialsViewStatus($serials);

        $param = [
            Consts::TITLE_PARAM => Message::VIEWED_TITLE,
            Consts::ITEMS_PARAM => $serials,
        ];
        return $this->getResponseByParameters(TwigPath::SERIALS_VIEWED, $param);
    }

    /**
     * @Route("/user/timetable", name="timetable")
     */
    public function getTimetable(Request $request)
    {
        return $this->getResponseByParameters(TwigPath::TIMETABLE, [Consts::TITLE_PARAM => Message::TIMETABLE_TITLE]);
    }

    /**
     * @param array $serials
     */
    private function updateSerialsViewStatus($serials)
    {
        $currentDate = new DateTime();
        foreach ($serials as $serial)
        {

            $date = $serial->getDateLastChange();
            if (is_null($date))
            {
                continue;
            }
            $interval = $currentDate->getTimestamp() - $date->getTimestamp();
            if ($interval >= Consts::EXPIRY_DATE)
            {
                $serial->setViewStatus(Message::STOPPED_WATCH_STATUS);
            }
        }

        $this->getObjectManager()->flush();
    }
}