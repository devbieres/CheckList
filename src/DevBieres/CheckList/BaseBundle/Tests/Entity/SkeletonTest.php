<?php
namespace DevBieres\CheckList\BaseBundle\Tests\Entity;

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


class SkeletonTest extends BaseTestCase {

		protected function getFullName() { return 'DevBieres\CheckList\BaseBundle\Entity\Skeleton'; }

		/**
		 * Test entity : maybe useless but as I do not use generation for accessor ...
		 */
		public function testEntity() {
				// Get the service
				$srv = $this->get('dvb.ckl.skeleton');

				// Get a new entity
				$e = $srv->getNew();
				$this->assertNotNull($e);

				// Affectation Label
				$e->setLabel("Test");
				$this->assertEquals("Test", $e->getLabel());
				$this->assertEquals($e->getLabel(), $e->__toString());

				// Affectation Description
				$e->setDescription("Description");
				$this->assertEquals("Description", $e->getDescription());

		} // /testEntity
} // /CheckListTest
