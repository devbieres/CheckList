<?php
namespace DevBieres\CheckList\BaseBundle\Tests\Twig\Extension;

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
use DevBieres\CheckList\BaseBundle\Twig\Extension\StateImageExtension;

class StateImageExtensionTest extends \PHPUnit_Framework_TestCase {

		public function testGetImageClassFilter() {

				$ext = new StateImageExtension();

				$this->assertEquals($ext->getStateImageFilter(0), "stop");
				$this->assertEquals($ext->getStateImageFilter(1), "pause");
				$this->assertEquals($ext->getStateImageFilter(2), "check");


		} // /testGetStateCssClassFilter


} // /StateCssClassExtensionTest
