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
use Symfony\Component\HttpFoundation\Response;

use DevBieres\CommonBundle\Controller\EntityController;

/**
 * @Route("/skeleton/{id}/item/")
 */
class SkeletonItemController extends EntityController
{
		/**
		 * Return the service
		 */
		public function getService() { return $this->get('dvb.ckl.skeleton.item'); }

		/**
		 * Return the service for the skeleton
		 */
		public function getSkeletonService() { return $this->get('dvb.ckl.skeleton'); }

	    /**
		 * Return the items of skeleton
		 * @param int $id
		 * @Template()
		 */
		public function listItemsAction($id) {
				// List the actions
				$list = $this->getService()->findAllByParentId($id);
				// Return
				return array('list'=> $list);
		} // /listItems

		/**
		 * Return the template form for an item form
		 * @Route("/ajax/new", name="skeleton_item_ajax_new")
		 * @Template()
		 */
		public function newAction($id) {
               // Get the new entity
			   $entity = $this->getService()->getNew();
			   // Get the form !
			   $form = $this->createForm(
					   $this->getService()->getForm(),
					   $entity,
					   array(
							   'action' => $this->generateUrl('skeleton_item_ajax_create', array('id'=>$id)),
							   'method' => 'POST'
					   )
			   )->createView();
			   // return
			   return array('form' => $form, 'id' => $id);
		} // /renderFormAction

		/**
		 * @Route("/ajax/create/", name="skeleton_item_ajax_create")
		 * Template("DevBieresCheckListHTMLViewBundle:SkeletonItem:listItems.html.twig")
		 */
		public function createAction(Request $request, $id) {

				// Get the new entity
				$entity = $this->getService()->getNew();
				$entity->setOwner($this->getUser());
				$parent = $this->getSkeletonService()->findOneById($id);
				$entity->setParent($parent);
				// Get the form
			    $form = $this->createForm(
					   $this->getService()->getForm(),
					   $entity);
				// Handle the request
				$form->handleRequest($request);
				// If valid
				if($form->isValid()) {
						$entity = $this->getService()->save($entity);
						return $this->render(
								'DevBieresCheckListHTMLViewBundle:SkeletonItem:listItems.html.twig',
								$this->listItemsAction($this->getRootId($parent))
						);
				} else {
						// TODO : translation
						return new Response(
								'Formulaire invalide', Response::HTTP_EXPECTATION_FAILED
						);
				}
			 	
		} // /createAction

		/**
		 * Get the parent Id
		 */
		protected function getRootId($parent) {
				// while
				while($parent->getParent() != null) { $parent = $parent->getParent(); }
				return $parent->getId();
		}

		/**
		 * Delete Action
		 * @Route("/ajax/delete/{itemId}", name="skeleton_item_ajax_delete")
		 * @Method("POST")
		 */
		public function deleteAction($id, $itemId) {
				// parent
				$parent = $this->getService()->findOneById($id);
				// Delete
				$this->getService()->delete($itemId);
				// Return
				return $this->render(
								'DevBieresCheckListHTMLViewBundle:SkeletonItem:listItems.html.twig',
								$this->listItemsAction($this->getRootId($parent))
		    	);

		} // deleteAction

} // /SkeletonItemController

