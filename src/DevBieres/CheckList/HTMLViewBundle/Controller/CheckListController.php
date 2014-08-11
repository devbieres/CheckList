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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use DevBieres\CommonBundle\Controller\EntityController;

/**
 * @Route("/checklist/")
 */
class CheckListController extends EntityController
{
		/**
		 * Return the service
		 */
		public function getService() { return $this->get('dvb.ckl.checklist'); }
		/**
		 * Return the service for the skeleton
		 */
		public function getSkeletonService() { return $this->get('dvb.ckl.skeleton'); }

		/**
		 * @Route("/create/skeleton/{id}", name="checklist_create_from_skeleton")
		 * @Method("GET")
		 */
		public function createAction($id) {
				// Get the skeleton
				$skeleton = $this->getSkeletonService()->findOneById($id);
				if(! $skeleton) {
						// TODO : translate
						return $this->createNotFoundException('No skeleton found');
				} // no skeleton found


				// Create
				$ck = $this->getService()->createFromSkeleton($skeleton);

				// Redirect
				return $this->redirect(
						$this->generateUrl('checklist_view', array('id' => $ck->getId()))
				);
		} // /createAction


		/**
		 * @Route("/view/{id}", name="checklist_view")
		 * @Template()
		 */
		public function viewAction($id) {
				// Get the entity
				$ck = $this->getService()->findOneById($id);
				if(! $ck) {
                      // TODO : translate
					  return $this->createNotFoundException('No checklist found');
				} // /no check list found

				// Return
				return array('checklist' => $ck);

		} // /viewAction

		/**
		 * @Route("/delete/{id}", name="checklist_delete")
		 */
		public function deleteAction($id) {
			 // Delete
			 $this->getService()->delete($id);	
			 // redirect
			 return $this->redirect($this->generateUrl('main'));
		} // /deleteAction
} // /CheckListController

