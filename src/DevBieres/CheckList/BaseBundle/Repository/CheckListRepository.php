<?php
namespace DevBieres\CheckList\BaseBundle\Repository;
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

class CheckListRepository extends \Doctrine\ORM\EntityRepository
{

		/**
		 * Return all the check list by user
		 * @param int $user_id
		 */
		public function findAllByUser($user_id) {

				// Request
				$q = $this->getEntityManager()
						->createQueryBuilder()
						->select('c')
						->from('DevBieresCheckListBaseBundle:CheckList', 'c')
						->innerJoin('d.owner','o')
						->where('o.id = :oid')
						->setParameter('oid', $user_id)
						->andWhere('c.parent is null')
						->orderBy('c.createdAt','asc');

				// Return
				return $q->getQuery()->execute();
		} // /findAllByUser


		/**
		 * Return all the function by check list id as parent
		 * Get the parents and the second descendants
		 * @param int $id
		 */
		public function findAllByParentId($id) {
				// Request
				$q = $this->getEntityManager()
						->createQueryBuilder()
						->select('c','p','i')
						->from('DevBieresCheckListBaseBundle:CheckList', 'c')
						->innerJoin('c.parent', 'p')
						->leftJoin('c.items', 'i')
						->where('p.id = :parent_id')
						->setParameter('parent_id', $id)
						->orderBy('c.label', 'asc');

				// Return
				return $q->getQuery()->execute();
		} // /findAllBySkeletonId
}
