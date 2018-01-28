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
        $items = $this->getDoctrine()->getRepository(SerialData::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('main/catalog.html.twig', [
			'genries' => Genry::getGenries(),
            'titleName' => "Каталог",
            "itemsData" => $items,
        ]);
    }

    /**
     * @Route("/item?id={id}", name="itempage", requirements={"id": "\d+"})
     */
    public function showItemPage(Request $request, $id)
    {
        $serialData = $this->getDoctrine()
            ->getRepository(SerialData::class)
            ->find($id);

        $serial = $this->getDoctrine()->getRepository(Serial::class)->findOneBy(['data' => $id]);

        $user = $this->getCurrentUser();
        $hasItem = false;
        if ($user)
        {
            global $serialId;
            $serialId = $id;
            $hasItem = $this->getCurrentUserHistory()->hasSerial($serialId);
        }

        // replace this example code with whatever you need
        return $this->render('itemPage/itemPage.html.twig', [
            'genries' => Genry::getGenries(),
            'titleName' => $serialData->getTitle(),
            'data' => $serialData,
            'previewInfo' => $serial,
            "hasItem" => $hasItem,
        ]);
    }

    /**
     * @Route("/input", name="inputForm")
     */
    public function showLoginForm(Request $request)
    {
        return $this->render('inputForm/inputForm.html.twig');
    }

    /**
     * @Route("/search?genry={genry}", name="searchBy")
     */
    public function findByGenre(Request $request, $genry) {
        $allItems = $this->getDoctrine()->getRepository(SerialData::class)->findAll();

        $items = array();

        $lowGenry = mb_strtolower($genry); // TODO: сделать получше и зарефакторить, при больших данных будет долго искать
        foreach ($allItems as $item) {
            $itemGenries = $item->getGenries();

            if (strpos($itemGenries, $lowGenry) !== false) {
                array_push($items, $item);
            }
        }

        return $this->render('main/catalog.html.twig', [
            'genries' => Genry::getGenries(),
            'titleName' => "Каталог",
            "itemsData" => $items,
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
