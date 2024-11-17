<?php

namespace DTOs;

use Enums\TargetUploadFolderEnum;
use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property string file_name
 * @property string file_type
 * @property string file_path
 * @property string full_path
 * @property string raw_name
 * @property string orig_name
 * @property string client_name
 * @property string file_ext
 * @property float file_size
 * @property bool is_image
 * @property int image_width
 * @property int image_height
 * @property string image_type
 * @property string image_size_str
 */
class FileDTO extends SimpleDTO
{
    /**
     * @var string $file_name
     */
    protected string $file_name;
    /**
     * @var string $file_type
     */
    protected string $file_type;
    /**
     * @var string $file_path
     */
    protected string $file_path;
    /**
     * @var string $full_path
     */
    protected string $full_path;
    /**
     * @var string $raw_name
     */
    protected string $raw_name;
    /**
     * @var string $orig_name
     */
    protected string $orig_name;
    /**
     * @var string $client_name
     */
    protected string $client_name;
    /**
     * @var string $file_ext
     */
    protected string $file_ext;
    /**
     * @var float $file_size
     */
    protected float $file_size;
    /**
     * @var bool $is_image
     */
    protected bool $is_image;
    /**
     * @var int $image_width
     */
    protected int $image_width;
    /**
     * @var int $image_height
     */
    protected int $image_height;
    /**
     * @var string $image_type
     */
    protected string $image_type;
    /**
     * @var string $image_size_str
     */
    protected string $image_size_str;

    public function __construct(array $input)
    {
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function __serialize(): array
    {
        return $this->getData();
    }

    public function __unserialize(array $data): void
    {
    }

    public function getFullUrl(TargetUploadFolderEnum $folder): string
    {
        return base_url("uploads/" . $folder->value . "/" . $this->file_name);
    }
}