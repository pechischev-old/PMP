<?php

namespace AppBundle\Controller;

use AppBundle\Constant\Consts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\FormValidate;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHistory;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Constant\TwigPath;
use AppBundle\Controller\UserController;

class SecurityController extends UserController {

    const HOMEPAGE = 'homepage';
    const SETTINGS_PAGE = 'settings';

    const SECURITY_FIREWALL = 'main';
    const LAST_USERNAME_PARAM = 'last_username';
    const ERROR_PARAM = 'error';
    const FORM_PARAM = 'form';

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(FormValidate::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setCapture(Consts::DEFAULT_USER_ICON);

            $this->appendObjectToBaseData($user);
            $this->appendObjectToBaseData($this->createUserHistory($user));

            $token = new UsernamePasswordToken($user, null, self::SECURITY_FIREWALL, $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            return $this->redirectToRoute(self::HOMEPAGE);
        }
        return $this->render(TwigPath::REGISTERY_FORM, [
            self::FORM_PARAM => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/save", name="saveSettings")
     */
    public function saveSettings(Request $request)
    {
        $currentUser = $this->getCurrentUser();

        if ($request->isMethod('POST'))
        {

            $currentUser->setFirstName($request->request->get('firstName'));
            $currentUser->setLastName($request->request->get('lastName'));
            $imageData = $request->request->get('icon');
            if ($imageData)
            {
                $currentUser->setCapture($imageData);
            }

            $email = $request->request->get('email');
            if ($email !== $currentUser->getEmail() && $email)
            {
                $currentUser->setEmail($email);
            }
            $password = $request->request->get('password');
            if ($password)
            {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($currentUser, $password);
                if ($password != $currentUser->getPassword())
                {
                    $currentUser->setPassword($password);
                }
            }

            $this->getObjectManager()->flush();
        }
        $json = array(
            "firstName" => $currentUser->getFirstName(),
            "lastName" => $currentUser->getLastName(),
            "email" => $currentUser->getEmail(),
            "capture" => $currentUser->getCapture(),
        );
        return new JsonResponse($json);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(TwigPath::LOGIN_FORM, [
                self::LAST_USERNAME_PARAM => $lastUsername,
                self::ERROR_PARAM => $error,
            ]
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    private function createUserHistory(User &$user)
    {
        $userHistory = new UserHistory();
        $userHistory->setUser($user);
        return $userHistory;
    }

}