<?php

namespace Menus;


use Illuminate\Support\Collection;
use Interfaces\IMenuProvider;
use Stringable;

require_once __DIR__ . "/../Interfaces/IMenuProvider.php";

abstract class BaseMenu implements IMenuProvider
{
    public function print(): string
    {
        return $this->list()->map(fn(Stringable $menu) => $menu->__toString())->implode(' ');
    }

    abstract public function list(): Collection;

    public function __toString(): string
    {
        return $this->print();
    }

    public function withLanguage(string $link, bool $addAtTheEnd = false): string
    {
        if ($addAtTheEnd) {
            return $link . "/" . $this->language;
        }

        return strtoupper($this->language) . "/" . $link;
    }
}