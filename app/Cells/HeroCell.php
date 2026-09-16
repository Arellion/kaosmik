<?php

namespace App\Cells;

use App\Entities\Hero;
use App\Models\RarityLevelModel;
use CodeIgniter\View\Cells\Cell;

class HeroCell extends Cell
{
    public $character;
    public string $context = 'roster';
}