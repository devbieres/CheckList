<?php
namespace DevBieres\CommonUserBundle\Form\Type;
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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Specialization of the FOS Registration Form in order to add Level
 * https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/overriding_forms.md
 */
class RegistrationFormType extends BaseType {

		public function buildForm(FormBuilderInterface $builder, array $options) {

				// parent
				parent::buildForm($builder, $options);

		} // /buildForm

		/**
		 * Name
		 */
		public function getName() {  return "devbieres_user_registration"; }

		public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
              $resolver->setDefaults(array(
					  'validation_groups' => array('registration'),
			          "data_class" => 'DevBieres\CommonUserBundle\Entity\User'
              ));
        }
} // /RegistrationFormType
