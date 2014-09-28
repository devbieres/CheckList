<?php

namespace A5sys\EoWBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
	/**
     * Just test a false login home page
	 */
    public function testFalseHomePage()
    {
		// Create client
		$client = static::createClient(array(), array());

		// Goes to the / URL
        $crawler = $client->request('GET', '/');
		$crawler = $client->followRedirect();
		// Check the login form
		$this->assertTrue($crawler->filter('form.form-signin')->count() > 0);

		// Just a false submit
		$form = $crawler->selectButton('submit')->form(array(
				'_username' => 'user',
				'_password' => 'p@$$word'
		));

		// Click on the button ... so I can get banned
		$client->submit($form);
		$crawler = $client->followRedirect();

		// Still the form
		$this->assertTrue($crawler->filter('form.form-signin')->count() > 0);

		 //*/
    }  // testHomePage



	/**
     * Just test with a true login
	 */
    public function testGoodHomePage()
    {


		// Create client
		$client = static::createClient(array(), array());
		$container = $client->getContainer();

		// Create a user ...
		$userService = $container->get('fos_user.user_manager');
		$user = $userService->createUser();
		$user->setUsername('good'); $user->setEmail("good@t.fr"); $user->setPlainPassword("test");
		$user->setEnabled(true);
		$userService->updateUser($user);

		//
		// Goes to the / URL
        $crawler = $client->request('GET', '/');
		$crawler = $client->followRedirect();
		// Check the login form
		$this->assertTrue($crawler->filter('form.form-signin')->count() > 0);

		// Just a false submit
		$form = $crawler->selectButton('submit')->form(array(
			'_username' => 'good',
			'_password' => 'test'
		));

		// Click on the button ... so I can get banned
		$crawler = $client->submit($form);
		$crawler = $client->followRedirect();

		// Still the form
		$this->assertFalse($crawler->filter('form.form-signin')->count() > 0);
		$this->assertTrue($crawler->filter('#open')->count() > 0);

		 //*/

	}

}

