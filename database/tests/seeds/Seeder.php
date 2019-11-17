<?php

declare(strict_types=1);

namespace Tests\Seeds;

abstract class Seeder
{
    abstract public function run(): void;
}
