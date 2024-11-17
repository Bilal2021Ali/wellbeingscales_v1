<?php

namespace Types;

class MenuLink
{
    public bool $isVisible = true;

    public function __construct(
        public string $name,
        public string $link,
        public string $icon
    )
    {
    }

    public function setIsVisible(bool $value): self
    {
        $this->isVisible = $value;
        return $this;
    }

    public function __toString(): string
    {
        if (!$this->isVisible) return '';

        return '<li class="">
                    <a href="' . base_url($this->link) . '">
                        <i class=""><img src="' . base_url($this->getIconsBasePath() . $this->icon) . '"  width="19px"></i>
                        <span>' . strtoupper(__($this->name)) . '</span>
                    </a>
                </li>';
    }

    protected function getIconsBasePath(): string
    {
        return "assets/images/icons/png_icons/";
    }
}