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
 * @Route("/skeleton")
 */
class SkeletonController extends EntityController
{
		/**
		 * Return the service
		 */
		public function getService() { return $this->get('dvb.ckl.skeleton'); }

		/**
		 * @Template()
		 */
		public function renderNewAction() {
				// Entity
				$entity = $this->getService()->getNew();

				// Get form
				$form = $this->createForm(
						$this->getService()->getForm(),
						$entity,
						array(
								'action' => $this->generateUrl('skeleton_create'),
								'method' => 'POST'
						)
				);

                $view = $form->createView();

				// return
				return array('form' => $view);

		} // /renderFormAction

		/**
		 * @Route("/create", name="skeleton_create")
		 * @Method("POST")
		 * @Template()
		 */
		public function createAction(Request $request) {

				// Entity
				$entity = $this->getService()->getNew();
				$entity->setOwner($this->getUser());

				// Get form
				$form = $this->createForm(
						$this->getService()->getForm(),
						$entity
				); // /getform

				// Handle request
				$form->handleRequest($request);

				//var_dump($entity);
				//die();

				// Valid ?
				if($form->isValid()) {
                        $entity =  $this->getService()->save($entity);
                        // return
				        return $this->redirect($this->generateUrl('main'));
				}


				// return
				return array('form' => $form->createView());

		} // /createAction

		/**
		 * Edit and root skeleton
		 * @Route("/edit/{id}", name="skeleton_edit")
		 * @Template()
		 */
		public function editAction(Request $request, $id) {
				return $this->_formAction(
						    $request,
							"PUT",
							"skeleton_update",
							"main",
							$id);
		} // editAction

		/**
		 * @Route("/update/{id}", name="skeleton_update")
		 * @Method("PUT")
		 * @Template("DevBieresCheckListHTMLViewBundle:Skeleton:edit.html.twig")
		 */
		public function updateAction(Request $request, $id) {

				return $this->_formAction(
						    $request,
							"PUT",
							"skeleton_update",
							"main",
							$id);

		} // /updateAction

		/**
		 * @Route("/delete/{id}", name="skeleton_delete")
		 */
		public function deleteAction($id) {
			 // Delete
			 $this->getService()->delete($id);	
			 // redirect
			 return $this->redirect($this->generateUrl('main'));
		} // /deleteAction

} // /SkeletonController

