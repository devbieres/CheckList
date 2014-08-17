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
 * Base class for a check list
 * @ORM\Entity(repositoryClass="DevBieres\CheckList\BaseBundle\Repository\CheckListRepository")
 */
class CheckList extends EntityBase {

		/**
		 * Owner
		 * @ORM\ManyToOne(targetEntity="DevBieres\CommonUserBundle\Entity\User")
		 * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
		 * @Assert\NotNull()
		 */
		private $owner;
		public function getOwner() { return $this->owner; }
		public function setOwner($value) { $this->owner = $value; }

		/**
		 * Skeleton
		 * @ORM\ManyToOne(targetEntity="Skeleton")
		 * @ORM\JoinColumn(name="skeleton_id", referencedColumnName="id")
		 * @Assert\NotNull()
		 */
		private $skeleton;
		public function getSkeleton() { return $this->skeleton;}
		public function setSkeleton($value) { $this->skeleton = $value; }

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
		 * @ORM\OneToMany(targetEntity="CheckList", mappedBy="parent", cascade={ "remove", "persist" })
		 * */
		private $items;
		public function getItems() { return $this->items; }

		/**
		 * Parent ? May be null if the node is root
		 * @ORM\ManyToOne(targetEntity="CheckList", inversedBy="items")
		 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
		 */
		private $parent;
		public function getParent() { return $this->parent; }
		public function setParent($value) { $this->parent = $value; }


		/**
		 * @ORM\Column(type="integer", nullable=false)
		 * @Assert\NotNull()
		 * @Assert\Range(min=0, max=2)
		 */
		private $state = CheckList::STATE_UNDONE;
		public function getState() { return $this->state; }
		public function setState($value) { $this->state = $value; }

		public function isUndone() { return $this->getState()==CheckList::STATE_UNDONE; }
		public function isPartial() { return $this->getState()==CheckList::STATE_PARTIAL; }
		public function isDone() { return $this->getState()==CheckList::STATE_DONE; }

		public function changeState() {
				if($this->isDone()) { $this->setState(CheckList::STATE_UNDONE); }
				else { $this->setState(CheckList::STATE_DONE); }
		} // /changeState

		/**
		 * Not done. Default value
		 */
		const STATE_UNDONE =  0;
		/**
		 * For items with sub items which some are done
		 */
		const STATE_PARTIAL = 1;
		/**
		 * DONE !! At least one things left ...
		 */
		const STATE_DONE = 2;

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

    /**
     * Add items
     *
     * @param \DevBieres\CheckList\BaseBundle\Entity\CheckList $items
     * @return CheckList
     */
    public function addItem(\DevBieres\CheckList\BaseBundle\Entity\CheckList $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \DevBieres\CheckList\BaseBundle\Entity\CheckList $items
     */
    public function removeItem(\DevBieres\CheckList\BaseBundle\Entity\CheckList $items)
    {
        $this->items->removeElement($items);
    }
}
