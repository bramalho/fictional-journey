<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Category
{
    /**
     * @MongoDB\Id
     */
    public $id;

    /**
     * @MongoDB\Field(type="string")
     */
    public $uid;

    /**
     * @MongoDB\Field(type="string")
     */
    public $name;
}
