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
 * Service class for the cehck list definition
 */
class SkeletonService extends BaseService
{

	/**
     * FullName
	 */
    protected function getFullEntityName() { return 'DevBieres\CheckList\BaseBundle\Entity\Skeleton'; }

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
	 * Return the form for a creation
	 */
	public function getForm() {
			return new \DevBieres\CheckList\BaseBundle\Form\NewSkeletonType();
	}


} // /SkeletonService

