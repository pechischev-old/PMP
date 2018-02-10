<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 10.02.2018
 * Time: 12:06
 */

namespace AppBundle\Controller;

use AppBundle\Controller\UserController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Constant\TwigPath;
use AppBundle\Constant\Consts;
use AppBundle\lng\Message;

use AppBundle\Entity\Series;
use AppBundle\Entity\Season;
use AppBundle\Entity\Serial;
use AppBundle\Entity\SerialData;

class AdminController extends UserController
{
    /**
     * @Route("/admin/add_serial", name="create_serial")
     */
    public function addSerial(Request $request)
    {
        return $this->getResponseByParameters(TwigPath::CREATE_SERIAL, array(Consts::TITLE_PARAM => Message::ADD_SERIAL));
    }

    /**
     * @Route("/admin/add_serial/action", name="create_serial_action")
     */
    public function createSerialAction(Request $request)
    {
        $params = $request->request;

        $endYear = $params->get("endYear");
        $seasonsInfo = $params->get("seasonsInfo");

        $data = new SerialData();
        $data->setTitle($params->get("title"));
        $data->setGenries($params->get("genries"));
        $data->setYear($params->get("startYear"));
        $endYear = !$endYear ? 0 : $endYear;
        $data->setEndYear($endYear);
        $data->setRate(8.7);

        $serialInfo = new Serial();
        $serialInfo->setDescription($params->get("description"));
        $serialInfo->setActors($params->get("actors"));
        $serialInfo->setData($data);

        foreach ($seasonsInfo as $seasonInfo)
        {
            $season = new Season();
            $season->setName($seasonInfo["seasonTitle"]);
            $season->setSerialData($data);

            $data->addSeason($season);

            for ($i = 1; $i <= $seasonInfo["seriesCount"]; $i++)
            {
                $serial = new Series();
                $serial->setSeason($season);
                $serial->setName((string)$i);

                $season->addSeries($serial);

                $this->getObjectManager()->persist($serial);
            }

            $this->getObjectManager()->persist($season);
        }

        $this->getObjectManager()->persist($data);
        $this->getObjectManager()->persist($serialInfo);
        $this->getObjectManager()->flush();

        return new Response();
    }
}