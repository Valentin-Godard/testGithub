<?php
namespace RedwaneValentin\Foot2Club\Contract;

use PDO;

interface Savable {
    public function save(PDO $pdo): void;
}