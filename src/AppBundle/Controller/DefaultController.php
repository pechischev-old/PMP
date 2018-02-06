<?php

namespace AppBundle\Controller;

use AppBundle\Constant\Genry;
use AppBundle\Entity\Serial;
use AppBundle\Entity\SerialData;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHistory;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Constant\TwigPath;
use AppBundle\Constant\Consts;
use AppBundle\lng\Message;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // TODO: get param for to filter data
        $items = $this->getDoctrine()->getRepository(SerialData::class)->findAll();

        $param = [
            Consts::TITLE_PARAM => Message::CATALOG_TITLE,
            Consts::DATA_PARAM => $items,
        ];

        return $this->getResponseByParameters(TwigPath::CATALOG, $param);
    }

    /**
     * @Route("/item?id={id}", name="itempage", requirements={"id": "\d+"})
     */
    public function showItemPage(Request $request, $id)
    {
        $serialData = $this->getDoctrine()
            ->getRepository(SerialData::class)
            ->find($id);

        $serial = $this->getDoctrine()->getRepository(Serial::class)->findOneBy([Consts::DATA => $id]);

        $hasItem = false;
        if ($this->getUser())
        {
            $hasItem = $this->getCurrentUserHistory()->hasSerial($id);
        }

        $param = [
            Consts::TITLE_PARAM => $serialData->getTitle(),
            Consts::SERIAL_INFO_PARAM => $serialData,
            Consts::PREVIEW_INFO_PARAM => $serial,
            Consts::EXIST_ITEM_PARAM => $hasItem,
        ];

        return $this->getResponseByParameters(TwigPath::SERIAL_VIEW, $param);
    }

    /**
     * @Route("/search?genry={genry}", name="searchBy")
     */
    public function findByGenre(Request $request, $genry)
    {
        $items = $this->getDoctrine()->getRepository(SerialData::class)->findAll();
        $filteredItems = $this->getFilteredItemsByGenre($genry, $items);

        $param = [
            Consts::TITLE_PARAM => Message::CATALOG_TITLE,
            Consts::DATA_PARAM => $filteredItems,
        ];

        return $this->getResponseByParameters(TwigPath::CATALOG, $param);
    }

    /**
     * @param $path
     * @param array $templateParameters
     * @return Response
     */
    protected function getResponseByParameters($path, $templateParameters)
    {
        $templateParameters[Consts::GENRIES_PARAM] = Genry::getGenries();
        return $this->render($path, $templateParameters);
    }

    /**
     * @return object
     */
    protected function getCurrentUser()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        return $em->getRepository(User::class)->find($id);
    }

    /**
     * @return object
     */
    protected function getCurrentUserHistory()
    {
        $user = $this->getCurrentUser();
        return $this->getDoctrine()->getRepository(UserHistory::class)->findOneBy([Consts::USER => $user->getId()]);
    }

    private function getFilteredItemsByGenre($genre, $items)
    {
        $filteredItems = array();

        $lowGenry = mb_strtolower($genre); // TODO: сделать получше и зарефакторить, при больших данных будет долго искать
        foreach ($items as $item) {
            $itemGenries = $item->getGenries();

            if (strpos($itemGenries, $lowGenry) !== false) {
                array_push($filteredItems, $item);
            }
        }

        return $filteredItems;
    }
}