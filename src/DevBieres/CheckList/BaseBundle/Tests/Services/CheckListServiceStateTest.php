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

class CheckListServiceStateTest extends BaseTestCase {

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


	protected function getFullName() { return 'DevBieres\CheckList\BaseBundle\Entity\CheckList'; }

	/**
	 * Create from skeleton
	 */
	public function testCreateFromSkeleton() {
			// Get the services
			$srvS = $this->get('dvb.ckl.skeleton');
			$srv = $this->get('dvb.ckl.checklist');
			$this->assertNull($srv->createFromSkeleton(null));

			// User and co
			$userService = $this->get('fos_user.user_manager');
			$user = $userService->createUser();
			$user->setUsername('premier'); $user->setEmail("t@t.fr"); $user->setPassword("test");
			$userService->updateUser($user);

			// Create a first skeleton
			$s1 = $srvS->getNew();
			$s1->setOwner($user); $s1->setLabel("1"); $s1->setDescription("Desc"); 
			// -- Create sub items
			$s11 = $srvS->getNew();
			$s11->setOwner($user); $s11->setLabel("11"); $s11->setDescription("Desc"); $s11->setParent($s1);
			$s1->addItem($s11);
			$s12 = $srvS->getNew();
			$s12->setOwner($user); $s12->setLabel("12"); $s12->setDescription("Desc"); $s12->setParent($s1);
			$s1->addItem($s12);
			// -- Create Sub sub items
			$s111 = $srvS->getNew();
			$s111->setOwner($user); $s111->setLabel("111"); $s111->setDescription("Desc"); $s111->setParent($s11);
			$s11->addItem($s111);
			// -- Save
			$srvS->save($s1);

			// Create a check list from skeleton
			$ck = $srv->createFromSkeleton($s1);

			// Check
			$this->assertNotNull($ck);
			$this->assertEquals($ck->getOwner(), $s1->getOwner());
			$this->assertEquals($ck->getSkeleton(), $s1);
			$this->assertEquals($ck->getLabel(), "1");
			$this->assertEquals($ck->getDescription(), "Desc");
			$this->assertEquals(count($ck->getItems()), 2);


			// Delete
			$srv->delete($ck);
			$srvS->delete($s1);

	} // / testCreateFromSkeleton

	/**
	 * Change state
	 */
	public function testChangeState() {
			// Get the services
			$srv = $this->get('dvb.ckl.checklist');

			// User and co
			$userService = $this->get('fos_user.user_manager');
			$user = $userService->createUser();
			$user->setUsername('premier'); $user->setEmail("t@t.fr"); $user->setPassword("test");
			$userService->updateUser($user);

			// Create
			$s1 = $srv->getNew();
			$s1->setOwner($user); $s1->setLabel("1"); $s1->setDescription("Desc"); 
			// -- Create sub items
			$s11 = $srv->getNew();
			$s11->setOwner($user); $s11->setLabel("11"); $s11->setDescription("Desc"); $s11->setParent($s1);
			$s1->addItem($s11);
			$s12 = $srv->getNew();
			$s12->setOwner($user); $s12->setLabel("12"); $s12->setDescription("Desc"); $s12->setParent($s1);
			$s1->addItem($s12);
			// -- Create Sub sub items
			$s111 = $srv->getNew();
			$s111->setOwner($user); $s111->setLabel("111"); $s111->setDescription("Desc"); $s111->setParent($s11);
			$s11->addItem($s111);
			// -- Save
			$srv->save($s1);

			// Check
			$this->assertNotNull($s1);
			$this->assertEquals(count($s1->getItems()), 2);

			// Check State
			$this->assertEquals($s1->getState(), 0);
			$this->assertEquals($s11->getState(), 0);
			$this->assertEquals($s12->getState(), 0);
			$this->assertEquals($s111->getState(), 0);

			// Change state of the last one
			$srv->changeState($s111->getId());

			// Check State
			$this->assertEquals($s1->getState(), 1);
			$this->assertEquals($s11->getState(), 2);
			$this->assertEquals($s12->getState(), 0);
			$this->assertEquals($s111->getState(), 2);

			// Change state of the last one
			$srv->changeState($s12->getId());

			// Check State
			$this->assertEquals($s1->getState(), 2);
			$this->assertEquals($s11->getState(), 2);
			$this->assertEquals($s12->getState(), 2);
			$this->assertEquals($s111->getState(), 2);

			// Delete
			$srv->delete($s1);
	}

} // CheckListServiceState

