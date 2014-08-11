<?php
namespace DevBieres\CommonUserBundle\Entity;
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

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Based on https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	public function getId() { return $this->id; }
	
	/**
	 * TODO : remove from this class
	 *  @ORM\OneToMany(targetEntity="DevBieres\CheckList\BaseBundle\Entity\Skeleton", mappedBy="owner")
	 */
	private $skeletons;
	public function getSkeletons() { return $this->skeletons; }


    public function __construct()
    {
        parent::__construct();
        // your own logic
		$this->skeletons = new \Doctrine\Common\Collections\ArrayCollection(); 

	}

} // User
