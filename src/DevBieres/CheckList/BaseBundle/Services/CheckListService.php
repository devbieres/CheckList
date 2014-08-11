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
	 * Create (save) and return a new check list created from the skeleton in parameters
	 */
	public function createFromSkeleton($skeleton) {
			// Create a new CheckList
			$ck = $this->getNewEntity();

			// Copy
			$ck->setLabel($skeleton->getLabel());
			$ck->setDescription($skeleton->getDescription());
			$ck->setOwner($skeleton->getOwner());
			$ck->setSkeleton($skeleton);

			// Children
			$ck = $this->copyItems($ck, $skeleton);

			// Save
			$this->save($ck);

	} // /createFromSkeleton


	/**
	 * Copy items froms skeletons to cheklist
	 */
	protected function copyItems($ck, $skeleton) {
			// Loop
			foreach($skeletons->getItems() as $i) {
					// New Entity
					$c = $this->getNewEntity();
					$c->setParent($ck);
					$c->setLabel($i->getLabel());
					$c->setDescription($i->getDescription());
					$c->setOwner($i->getOwner());

					// Items
					$c = $this->copyItems($c, $i);

			} // end loop

			// return
			return $ck;

	} // /copyItems

}

