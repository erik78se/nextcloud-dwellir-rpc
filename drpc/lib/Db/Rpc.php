<?php
namespace OCA\DRpc\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Rpc extends Entity implements JsonSerializable {

    protected $name;
    protected $userId;
    protected $wsuri;
    protected $httpuri;
    protected $notes;

    public function __construct() {
        $this->addType('id','integer');
    }

    /*
     * Just return a few of the items in the database for now.
     */
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ws' => $this->wsuri,
            'http' => $this->httpuri
        ];
    }
}