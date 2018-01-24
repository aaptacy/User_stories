<?php

namespace UserStoriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="UserStoriesBundle\Repository\GroupsRepository")
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
    * @ORM\ManyToMany(targetEntity = "User", mappedBy = "groups")
    */
    public $users;

     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
 
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Groups
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set members
     *
     * @param array $members
     *
     * @return Groups
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Get members
     *
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add user
     *
     * @param \UserStoriesBundle\Entity\User $user
     *
     * @return Groups
     */
    public function addUser(\UserStoriesBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserStoriesBundle\Entity\User $user
     */
    public function removeUser(\UserStoriesBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
