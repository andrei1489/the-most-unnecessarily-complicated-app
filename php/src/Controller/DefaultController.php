<?php
/**
 * Created by IntelliJ IDEA.
 * User: adumitrescu
 * Date: 09.12.2018
 * Time: 22:19
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultAction(){
        return $this->render('base.html.twig');
    }
}