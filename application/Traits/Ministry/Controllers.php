<?php

namespace Traits\Ministry;

use CI_URI;

/**
 * @property CI_URI $uri
 */
trait Controllers
{
    public function controllers(): void
    {
        $page = $this->uri->segment(4);

        match ($page) {
            "manage" => $this->manageControllers(),
            default => $this->controllersLinks(),
        };
    }

    public function controllersLinks(): void
    {
        $data['links'] = [
            [
                "name" => "Manage Controllers",
                "link" => base_url(self::LANGUAGE . '/DashboardSystem/controllers/manage'),
                "desc" => "",
                "icon" => "r_prefix.png"
            ]
        ];
        $this->show('EN/Global/Links/Lists', $data);
    }

    public function manageControllers(): void
    {
        $this->controllersManager->crud();
    }
}