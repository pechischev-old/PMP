<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SerialData;
use AppBundle\Entity\User\UserSerialData;
use AppBundle\Entity\User\UserSeason;
use AppBundle\Entity\User\UserSeries;
use AppBundle\Constant\Consts;
use AppBundle\Controller\DefaultController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SerialController extends DefaultController
{
    /**
     * @Route("/item/add?id={id}", name="add_serial", requirements={"id" = "\d+"})
     */
    public function addSerialAction($id)
    {
        $history = $this->getCurrentUserHistory();

        $data = $this->createUserSerialData($id);
        $data->setHistory($history);
        $history->addSerialDatum($data);

        $this->getObjectManager()->flush();

        return $this->redirectToRoute('itempage', array(Consts::ID => $id));
    }

    /**
     * @Route("/item/remove?id={id}", name="remove_serial", requirements={"id" = "\d+"})
     */
    public function removeSerialAction($id)
    {
        $data = $this->getObjectManager()->getRepository(UserSerialData::class)->findOneBy(['serialData' => $id]);;
        if ($data)
        {
            $seasons = $data->getUserSeason();
            foreach ($seasons as &$season) {
                $series = $season->getSeries();

                foreach ($series as &$item) {
                    $season->removeSeries($item);
                    $this->getObjectManager()->remove($item);
                }

                $data->removeUSerSeason($season);
                $this->getObjectManager()->remove($season);
            }

            $this->getObjectManager()->remove($data);

            $history = $this->getCurrentUserHistory();
            $history->removeSerialDatum($data);

            $this->getObjectManager()->flush();
        }

        return $this->redirectToRoute('itempage', array(Consts::ID => $id));
    }

    private function createUserSerialData($id)
    {
        $data = $this->getObjectManager()->find(SerialData::class, $id);

        $userData = new UserSerialData();
        $userData->setViewStatus("не посмотрено");
        $userData->setSerialData($data);

        $seasons = $data->getSeason();
        foreach ($seasons as &$season) {
            $userData->addUserSeason($this->createUserSeason($season, $userData));
        }

        $this->getObjectManager()->persist($userData);
        return $userData;
    }

    private function createUserSeason($seasonInfo, $data)
    {
        $season = new UserSeason();
        $season->setSeason($seasonInfo);
        $season->setVisibled(false);
        $season->setSerialData($data);

        $series = $season->getSeries();
        foreach ($series as &$part) {
            $season->addSeries($this->createUserSeries($part, $season));
        }

        $this->getObjectManager()->persist($season);

        return $season;
    }

    private function createUserSeries($seriesInfo, $season)
    {
        $series = new UserSeries();
        $series->setSeries($seriesInfo);
        $series->setVisible(false);
        $series->setSeason($season);

        $this->getObjectManager()->persist($series);

        return $series;
    }

    private function getObjectManager()
    {
        return $this->getDoctrine()->getManager();
    }
}