<?php
namespace DevBieres\CheckList\BaseBundle\Tests\Services;

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


use DevBieres\CheckList\BaseBundle\Tests\Entity\BaseTestCase;

class SkeletonServiceTest extends BaseTestCase {

   /**
    * tearDown
    */
    public function setUp() {
       parent::setUp();
       $this->deleteAll();
    } // /tearDown

	/**
	 * deleteAll
	 */
	protected function deleteAll() {
        $this->delete('CheckList');
		$this->delete('Skeleton');
		$this->delete('user');
	} // /deleteAll


	protected function getFullName() { return 'DevBieres\CheckList\BaseBundle\Entity\Skeleton'; }
	
	/**
	 * findAllByUser
	 */
	public function testFindAllByParentId() {
			// Get the service
			$srv = $this->get('dvb.ckl.skeleton.item');
			$this->assertNull($srv->findAllByParent(null));

			// User and co
			$userService = $this->get('fos_user.user_manager');
			$user = $userService->createUser();
			$user->setUsername('premier'); $user->setEmail("t@t.fr"); $user->setPassword("test");
			$userService->updateUser($user);

			// Create a first check list
			$ck1 = $srv->getNew();
			$ck1->setOwner($user); $ck1->setLabel("1"); $ck1->setDescription("Desc"); 
			$srv->save($ck1);

			// No subitems
			$this->assertEquals(0, count($srv->findAllByParent($ck1)));

			// Create two sub items
			$ck11 = $srv->getNew();
			$ck11->setOwner($user); $ck11->setLabel("11"); $ck11->setDescription("Desc"); $ck11->setParent($ck1);
			$srv->save($ck11);
			$ck12 = $srv->getNew();
			$ck12->setOwner($user); $ck12->setLabel("12"); $ck12->setDescription("Desc"); $ck12->setParent($ck1);
			$srv->save($ck12);

			// Check
			$this->assertEquals(2, count($srv->findAllByParent($ck1)));
			$this->assertEquals(0, count($srv->findAllByParent($ck11)));
			$this->assertEquals(0, count($srv->findAllByParent($ck12)));

			// Create a sub sub items
			$ck111 = $srv->getNew();
			$ck111->setOwner($user); $ck111->setLabel("111"); $ck111->setDescription("Desc"); $ck111->setParent($ck11);
			$srv->save($ck111);

			// Check
			$this->assertEquals(2, count($srv->findAllByParent($ck1)));
			$this->assertEquals(1, count($srv->findAllByParent($ck11)));
			$this->assertEquals(0, count($srv->findAllByParent($ck12)));

			// Create a first check list
			$ck2 = $srv->getNew();
			$ck2->setOwner($user); $ck2->setLabel("2"); $ck2->setDescription("Desc"); 
			$srv->save($ck2);

			// Check
			$this->assertEquals(2, count($srv->findAllByParent($ck1)));
			$this->assertEquals(1, count($srv->findAllByParent($ck11)));
			$this->assertEquals(0, count($srv->findAllByParent($ck12)));
			$this->assertEquals(0, count($srv->findAllByParent($ck2)));

			// Delete
			$srv->delete($ck111);
			$srv->delete($ck11);
			$srv->delete($ck12);

	} // / testFindAllByParentId

	/**
	 * findAllByUser
	 */
	public function testFindAllByUser() {
			// Get the service
			$srv = $this->get('dvb.ckl.skeleton');

			// Test null ==> null
			$this->assertNull($srv->findAllByUser(null));

			// User and co
			$userService = $this->get('fos_user.user_manager');
			$user = $userService->createUser();
			$user->setUsername('premier'); $user->setEmail("t@t.fr"); $user->setPassword("test");
			$userService->updateUser($user);

			// 0
			$this->assertEquals(0, count($srv->findAllByUser($user)));

			// Create a first checklist
			$ck1 = $srv->getNew();
			$ck1->setOwner($user); $ck1->setLabel("1"); $ck1->setDescription("Desc"); 
			$srv->save($ck1);

			// 1
			$this->assertEquals(1, count($srv->findAllByUser($user)));

			// Create a second skeleton
			$ck2 = $srv->getNew();
			$ck2->setOwner($user); $ck2->setLabel("2"); $ck2->setDescription("Desc"); 
			$srv->save($ck2);

			// 2
			$this->assertEquals(2, count($srv->findAllByUser($user)));

			// Create second level for each item
			$ck11 = $srv->getNew();
			$ck11->setOwner($user); $ck11->setLabel("1"); $ck11->setDescription("Desc"); $ck11->setParent($ck1);
			$srv->save($ck11);

			// 2 (no change : the service only root)
			$this->assertEquals(2, count($srv->findAllByUser($user)));
			$srv->delete($ck11->getId());

			// Create a new user
			$userService = $this->get('fos_user.user_manager');
			$user2 = $userService->createUser();
			$user2->setUsername('deuxieme'); $user2->setEmail("t2@t.fr"); $user2->setPassword("test");
			$userService->updateUser($user2);

			// 0
			$this->assertEquals(0, count($srv->findAllByUser($user2)));

			// Create a first checklist
			$ck1 = $srv->getNew();
			$ck1->setOwner($user2); $ck1->setLabel("1"); $ck1->setDescription("Desc"); 
			$srv->save($ck1);

			// 1 : user 2 has on skeleton
			$this->assertEquals(1, count($srv->findAllByUser($user2)));

			// 2 (no change)
			$this->assertEquals(2, count($srv->findAllByUser($user)));

	} // /testFindAllByUser

}

