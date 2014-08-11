<?php
namespace DevBieres\CheckList\HTMLViewBundle\Controller;

/*
 * ----------------------------------------------------------------------------
 * « LICENCE BEERWARE » (Révision 42):
 * <thierry<at>lafamillebn<point>net> a créé ce fichier. Tant que vous conservez cet avertissement,
 * vous pouvez faire ce que vous voulez de ce truc. Si on se rencontre un jour et
 * que vous pensez que ce truc vaut le coup, vous pouvez me payer une bière en
 * retour. 
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <thierry<at>lafamillebn<point>net> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. 
 * ----------------------------------------------------------------------------
 * Plus d'infos : http://fr.wikipedia.org/wiki/Beerware
 * ----------------------------------------------------------------------------
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     * @Template()
     */
    public function indexAction()
    {
			// Service
			$service = $this->get('dvb.ckl.skeleton');

			// List
			$skeletons = $this->get('dvb.ckl.skeleton')->findAllByUser($this->getUser());

		    // Entity and Form
			$entity = $service->getNew();
			// Get form
			$form = $this->createForm(
						$service->getForm(),
						$entity,
						array(
								'action' => $this->generateUrl('skeleton_create'),
								'method' => 'POST'
						)
				);

			// return
			return array('skeletons' => $skeletons, 'form' => $form->createView());
    }
}
