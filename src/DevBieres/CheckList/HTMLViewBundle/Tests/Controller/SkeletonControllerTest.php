<?php

namespace A5sys\EoWBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SkeletonControllerTest extends WebTestCase
{

	/**
	 * Does the login function and return the client
	 */
    protected function doLogin($username) {
		// Create client
		$client = static::createClient(array(), array());
		$container = $client->getContainer();

		// Create a user ...
		$userService = $container->get('fos_user.user_manager');
		$user = $userService->createUser();
		$user->setUsername($username); $user->setEmail($username . "@t.fr"); $user->setPlainPassword("test");
		$user->setEnabled(true);
		$userService->updateUser($user);

		//
		// Goes to the / URL
        $crawler = $client->request('GET', '/');
		$crawler = $client->followRedirect();
		// Check the login form
		$this->assertTrue($crawler->filter('form.form-signin')->count() > 0);

		// Just a submit
		$form = $crawler->selectButton('submit')->form(array(
			'_username' => $username,
			'_password' => 'test'
		));

		// Click on the button ... so I can get banned
		$crawler = $client->submit($form);
		$crawler = $client->followRedirect();

		// Still the form
		$this->assertFalse($crawler->filter('form.form-signin')->count() > 0);
		$this->assertTrue($crawler->filter('#open')->count() > 0);


		// Return
		return $client;

	} // doLogin
	/**
     * Create Action
	 */
    public function testCreateAction()
    {
		// Do Login
		$client = $this->doLogin('sklca');

		// Go to the skeleton
        $crawler = $client->request('GET', '/');

		// Click on the open button
		$link = $crawler->filter('#open')->link();
		$crawler = $client->click($link);
        // Check if form open
		$this->assertTrue($crawler->filter('#form_skeleton_new')->count() > 0);
		// Get the form
		$form = $crawler->selectButton('Enregistrer')->form(
				array(
			'devbieres_checklist_basebundle_new_skeleton[label]' => 'Premiere Liste',
			'devbieres_checklist_basebundle_new_skeleton[description]' => 'Une première liste'
	    )); 
		// Submit and following
		$crawler = $client->submit($form);
		$crawler = $client->followRedirect();
		//echo $crawler->text();

		// Check
		$this->assertTrue($crawler->filter('html:contains("Une première liste")')->count() > 0);

	} // testCreateAction

} 

