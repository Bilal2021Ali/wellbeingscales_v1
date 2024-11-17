<?php

namespace Interfaces;

interface IMiddleware
{
    public function handle(array $parameters): void;
}