<?php

/*
 * Copyright (C) 2015-2016 Michael Joyce <ubermichael@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Misbehaving journals may be Blacklisted until they correct what ails them.
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="BlacklistRepository")
 */
class Blacklist
{
    /**
     * Database ID.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Journal UUID, as generated by the PLN plugin. This cannot be part
     * of a relationship - a journal may be listed before we have
     * a record of it.
     *
     * @var string
     * @Assert\Uuid(strict=false)
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $uuid;

    /**
     * Short message describing why the journal was listed.
     *
     * @var type
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * The date the blacklist entry was created.
     *
     * @var string
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uuid.
     *
     * @param string $uuid
     *
     * @return Blacklist
     */
    public function setUuid($uuid)
    {
        $this->uuid = strtoupper($uuid);

        return $this;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Blacklist
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the created timestamp. Called automatically.
     *
     * @todo figure out consistent naming for the timestamping functions
     *
     * @ORM\PrePersist
     */
    public function setTimestamp()
    {
        $this->created = new DateTime();
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return Blacklist
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * The deposit's uuid is the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->uuid;
    }
}
