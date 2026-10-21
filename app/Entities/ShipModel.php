<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ShipModel extends Entity
{
    protected $attributes = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
