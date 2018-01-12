<?php

namespace AppBundle\Controller;

use AppBundle\Constant\Genry;
use AppBundle\Entity\Serial;
use AppBundle\Entity\SerialData;
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
        // replace this example code with whatever you need
        return $this->render('main/catalog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
			'genries' => Genry::getGenries(),
            'titleName' => "Каталог",
            "itemsData" => $this->getDoctrine()->getRepository(SerialData::class)->findAll(),
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

        // replace this example code with whatever you need
        return $this->render('itemPage/itemPage.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'genries' => Genry::getGenries(),
            'titleName' => $serialData->getTitle(),
            'data' => $serialData,
            'previewInfo' => $serial,
        ]);
    }

    /**
     * @Route("/input", name="inputForm")
     */
    public function showLoginForm(Request $request)
    {
        return $this->render('inputForm/inputForm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
