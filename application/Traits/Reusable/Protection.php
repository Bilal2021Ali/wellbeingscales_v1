<?php

namespace Traits\Reusable;

use Response;

/**
 * @property Response $response
 */
trait Protection
{
    private function isMinistry(): bool
    {
        return self::TYPE === "ministry";
    }

    private function isSchool(): bool
    {
        return self::TYPE === "school";
    }

    private function showForMinistriesOnly(): void
    {
        $this->response->abort_if(403, !$this->isMinistry());
    }

    private function showForSchoolsOnly(): void
    {
        $this->response->abort_if(403, !$this->isSchool());
    }

    private function controllerName(): string
    {
        return  $this->isMinistry() ? "DashboardSystem" : "schools";
    }
}