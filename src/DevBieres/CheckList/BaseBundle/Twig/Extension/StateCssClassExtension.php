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

class StateCssClassExtension extends \Twig_Extension {

     public function getFilters() {

	     return array(
		    new \Twig_SimpleFilter('statecssclass', array($this, 'getStateCssClassFilter'))
	     );
     } // /getFilters

     public function getStateCssClassFilter($state) {
           switch($state) {
		   case CheckList::STATE_DONE : return "success";
		   case CheckList::STATE_PARTIAL : return "warning";
	       default: return "danger";
	   }
     } // getReportLevelClassFilter

     public function getName() { return 'state_css_class_extension'; }

} // /StateCssClass
