<?php
namespace DevBieres\CheckList\BaseBundle\Twig\Extension;
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

use DevBieres\CheckList\BaseBundle\Entity\CheckList;

class StateImageExtension extends \Twig_Extension {

     public function getFilters() {

	     return array(
				 new \Twig_SimpleFilter(
						       'stateimage', 
							   array($this, 'getStateImageFilter')
					   )
	     );
     } // /getFilters

     public function getStateImageFilter($state) {
           switch($state) {
		   case CheckList::STATE_DONE : return "check";
		   case CheckList::STATE_PARTIAL : return "pause";
	       default: return "stop";
	   }
     } // getReportLevelClassFilter

     public function getName() { return 'state_image_extension'; }

} // /StateCssClass
