<?php

namespace Interfaces;

use Illuminate\Support\Collection;
use Types\MenuLink;

interface IMenuProvider
{
    /**
     * @return Collection<MenuLink>
     */
    public function list(): Collection;

    public function print(): string;

    public function __toString(): string;

}