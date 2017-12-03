<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Serial;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    private $genries = array(
        'Мультсериалы',
        'Биография',
        'Детектив',
        'Драма',
        'Комедия',
        'Криминал',
        'Хоррор',
        'Семейные',
        'Фантастика',
        'Фэнтези',
        'Исторические',
    );

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('main/catalog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
			'genries' => $this->genries,
            'titleName' => "Каталог",
            "items" => $this->getDoctrine()->getRepository(Serial::class)->findAll(),
        ]);
    }

    /**
     * @Route("/item?id={id}", name="itempage", requirements={"id": "\d+"})
     */
    public function showItemPage(Request $request, $id)
    {
        $serial = $this->getDoctrine()
            ->getRepository(Serial::class)
            ->find($id);

        if (!$serial) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // replace this example code with whatever you need
        return $this->render('itemPage/itemPage.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'genries' => $this->genries,
            'titleName' => $serial->getTitle(),
            'item' => $serial,
        ]);
    }
}
