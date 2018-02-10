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

class AdminController extends UserController
{
    /**
     * @Route("/admin/add_serial", name="create_serial")
     */
    public function addSerial(Request $request)
    {
        return $this->getResponseByParameters(TwigPath::CREATE_SERIAL, array(Consts::TITLE_PARAM => Message::ADD_SERIAL));
    }
}