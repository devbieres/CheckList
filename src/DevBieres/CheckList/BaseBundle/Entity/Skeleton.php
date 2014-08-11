<?php
namespace DevBieres\CheckList\BaseBundle\Entity;

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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use JMS\Serializer\Annotation as JMS;

use DevBieres\CommonBundle\Entity\EntityBase;

/**
 * Base class for a skeleton of check list
 * @ORM\Entity(repositoryClass="DevBieres\CheckList\BaseBundle\Repository\SkeletonRepository")
 */
class Skeleton extends EntityBase {

		/**
		 * Owner
		 * @ORM\ManyToOne(targetEntity="DevBieres\CommonUserBundle\Entity\User", inversedBy="definitions")
		 * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
		 * @Assert\NotNull()
		 */
		private $owner;
		public function getOwner() { return $this->owner; }
		public function setOwner($value) { $this->owner = $value; }

		/**
		 * Label
		 * @ORM\Column(type="string")
		 * @Assert\NotBlank()
		 */
		protected $label;
		public function getLabel() { return $this->label; }
		public function setLabel($value) { $this->label = $value; }

		/**
		 * Description
		 * @ORM\Column(type="text", nullable=true)
		 * @Assert\NotBlank()
		 */
		protected $description = " ";
		public function getDescription() { return $this->description; }
		public function setDescription($value) { $this->description = $value; }

		/**
		 * A check list contains items that can contains items ...
		 * @ORM\OneToMany(targetEntity="Skeleton", mappedBy="parent", cascade="remove")
		 * */
		private $items;
		public function getItems() { return $this->items; }

		/**
		 * Parent ? May be null if the node is root
		 * @ORM\ManyToOne(targetEntity="Skeleton", inversedBy="items")
		 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
		 */
		private $parent;
		public function getParent() { return $this->parent; }
		public function setParent($value) { $this->parent = $value; }

		/**
		 * Init the collection
		 */
		public function __construct() {
				$this->items = new \Doctrine\Common\Collections\ArrayCollection();
		} 

		/**
		 * Return the label
		 * */
		public function __toString() { return $this->getLabel(); }

} // /Skeleton
