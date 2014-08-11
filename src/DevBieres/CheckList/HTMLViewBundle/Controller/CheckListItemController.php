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
 * @Route("/checklist/{id}/item/")
 */
class CheckListItemController extends EntityController
{
		/**
		 * Return the service
		 */
		public function getService() { return $this->get('dvb.ckl.checklist'); }

	    /**
		 * Return the items of skeleton
		 * @param int $id
		 * @Template()
		 */
		public function listAction($id) {
				// List the actions
				$list = $this->getService()->findAllByParentId($id);
				// Return
				return array('list'=> $list);
		} // /listItems

		/**
		 * Change state of the item
		 * @Route("/changeState/{itemId}", name="checklist_item_ajax_change_state")
		 */
		public function changeStateAction($id, $itemId) {
				// Call the service
				$entity = $this->getService()->changeState($itemId);
				if(! $entity) {
                      // TODO : translate
					  return $this->createNotFoundException('No checklist found');
				} // /no check list found
				// return
				return $this->render(
						'DevBieresCheckListHTMLViewBundle:CheckListItem:list.html.twig',
						$this->listAction($this->getRootId($entity))
				);

		} // changeState

		/**
		 * Get the parent Id
		 */
		protected function getRootId($parent) {
				// while
				while($parent->getParent() != null) { $parent = $parent->getParent(); }
				return $parent->getId();
		}
} // /CheckListItemController

