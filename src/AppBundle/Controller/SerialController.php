<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SerialData;
use AppBundle\Entity\User\UserSerialData;
use AppBundle\Entity\User\UserSeason;
use AppBundle\Entity\User\UserSeries;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SerialController extends Controller
{
    public function removeData($id, &$em) {
        $userData = $em->getRepository(UserSerialData::class)->findOneBy(['serialData' => $id]);

        $seasons = $userData->getUserSeason();
        foreach ($seasons as &$season) {
            $series = $season->getSeries();

            foreach ($series as &$item) {
                $season->removeSeries($item);
                $em->remove($item);
            }

            $userData->removeUSerSeason($season);
            $em->remove($season);
        }

        $em->remove($userData);
        return $userData;
    }

    public function createUserSerialData($id, &$em) {
        $data = $em->getRepository(SerialData::class)->find($id);

        $userData = new UserSerialData();
        $userData->setViewStatus("не посмотрено");
        $userData->setSerialData($data);

        $seasons = $data->getSeason();
        foreach ($seasons as &$season) {
            $userData->addUserSeason($this->createUserSeason($season, $userData, $em));
        }

        $em->persist($userData);
        return $userData;
    }

    private function createUserSeason($season, $data, $em) {
        $userSeason = new UserSeason();
        $userSeason->setSeason($season);
        $userSeason->setVisibled(false);
        $userSeason->setSerialData($data);

        $series = $season->getSeries();
        foreach ($series as &$part) {
            $userSeason->addSeries($this->createUserSeries($part, $userSeason, $em));
        }

        $em->persist($userSeason);

        return $userSeason;
    }

    private function createUserSeries($series, $season, $em) {
        $userSeries = new UserSeries();
        $userSeries->setSeries($series);
        $userSeries->setVisible(false);
        $userSeries->setSeason($season);

        $em->persist($userSeries);

        return $userSeries;
    }
}