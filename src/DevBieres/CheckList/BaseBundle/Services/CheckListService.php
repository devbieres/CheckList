<?php
namespace DevBieres\CheckList\BaseBundle\Services;

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

use DevBieres\CommonBundle\Services\EntityService as BaseService;
//use DevBieres\CommonBundle\Services\IEntityFormService;

use DevBieres\CheckList\BaseBundle\Entity\CheckList;

/**
 * Service class for the check list definition
 */
class CheckListService extends BaseService
{

	/**
     * FullName
	 */
    protected function getFullEntityName() { return 'DevBieres\CheckList\BaseBundle\Entity\CheckList'; }

	
	/**
	 * Service for the definition (skeleton) of check list
	 */
	private $srvDefinition;
	public function getDefinitionService() { return $this->srvDefinition; }
	public function setDefinitionService($value) { $this->srvDefinition = $value; }

	/**
	 * Return all definition for an user
	 * @param User $user
	 * @return Collection or null (if user is null)
	 */
	public function findAllByUser($user) {
			if($user) {
			   // Direct call to the repo
			   return $this->getRepo()->findAllByUser($user->getId());
			} else { return null; }
	} // /findAllByUser

	/**
	 * Return all items for a parent
	 */
	public function findAllByParent($parent) {
			if($parent) { return $this->findAllByParentId($parent->getId()); }
			return null;
	} // /findAllByParent

	/**
	 * Return all for a root skeleton id
	 * @param int $id
	 * @return Collection or null (if user is null)
	 */
	public function findAllByParentId($id) {
	   return $this->getRepo()->findAllByParentId($id);
	} // /findAllBySkeletonById

	/**
	 * Create (save) and return a new check list created from the skeleton in parameters
	 */
	public function createFromSkeleton($skeleton) {
			// Check
			if(! $skeleton) { return null; }

			// Create a new CheckList
			$ck = $this->getNew();

			// Copy
			$ck->setLabel($skeleton->getLabel());
			$ck->setDescription($skeleton->getDescription());
			$ck->setOwner($skeleton->getOwner());
			$ck->setSkeleton($skeleton);

			// Children
			$ck = $this->copyItems($ck, $skeleton);

			// Save
			$this->save($ck);

		    // return
			return $ck;

	} // /createFromSkeleton


	/**
	 * Copy items froms skeletons to cheklist
	 */
	protected function copyItems($ck, $skeleton) {
			// Loop
			foreach($skeleton->getItems() as $i) {
					// New Entity
					$c = $this->getNew();
					$c->setParent($ck);
					$c->setLabel($i->getLabel());
					$c->setDescription($i->getDescription());
					$c->setOwner($i->getOwner());

					// Items
				    $c = $this->copyItems($c, $i);

					// Add
					$ck->addItem($c);

			} // end loop

			// return
			return $ck;

	} // /copyItems

	/**
	 * Change state of the item and update its parents (if needed)
	 * @param $id interger id (must exist)
	 * @return null or the changed state entity
	 */
	public function changeState($id) {
			// #####################
			// Manage item
			// #####################
			// Find
			$entity = $this->findOneById($id);
			if(! $entity) { return null;}

			// Change state
			$entity->changeState();

			// Save
			$this->save($entity);

			//#####################
			// Parent
			//#####################
			if($entity->getParent()) {
			   $this->updateParentState($entity->getParent());
			}

			// Return
			return $entity;
	} // /changeState

	/**
	 * Update the state of the entity by checking son's state
	 **/
	protected function updateParentState($parent) {
			// Get children's state
			$states = $this->getRepo()->findAllChildrenState($parent->getId());

			//var_dump($states);
			// If only one line ==> same states so directly takes the states
			// if two lines ==> running
			if(count($states) == 1) { $parent->setState($states[0]['state']); }
			else { $parent->setState(CheckList::STATE_PARTIAL); }

			// save
			$this->save($parent);

			// Following
			if($parent->getParent()) {
			   $this->updateParentState($parent->getParent());
			}

	} // /updateParent

}

