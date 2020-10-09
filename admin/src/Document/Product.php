<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Product
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

    /**
     * @MongoDB\Field(type="integer")
     */
    public $price;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Category")
     */
    public $category;
}
