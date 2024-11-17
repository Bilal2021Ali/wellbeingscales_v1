<?php

namespace Traits\Reusable;

require_once __DIR__ . "/../../Exceptions/FileUploadException.php";
require_once __DIR__ . "/../../DTOs/FileDTO.php";

use CI_Loader;
use CI_Upload;
use DTOs\FileDTO;
use Enums\TargetUploadFolderEnum;
use Exception;
use Exceptions\FileUploadException;
use Illuminate\Support\Collection;

/**
 * @property CI_Loader $load
 * @property CI_Upload $upload
 */
trait FileUpload
{
    private array $defaultConfig = [
        'max_size' => 5000, // 5MB
        'encrypt_name' => true
    ];

    private function getTargetedFolder(TargetUploadFolderEnum $folder): string
    {
        return './uploads/' . $folder->value;
    }

    /**
     * @return Collection<FileDTO>
     * @throws Exception
     * @throws FileUploadException
     */
    private function uploadFiles(string $inputName, array $config): Collection
    {
        throw_if(!str_ends_with($inputName, 's'), new Exception("The input name must be plural"));

        $inputNameSingular = substr($inputName, 0, -1);
        $files = $_FILES[$inputName];
        if (empty($files['name'])) return collect([]);

        try {
            $uploaded = [];
            for ($i = 0; $i < count($files['name']); $i++) {
                $_FILES[$inputNameSingular] = $this->buildSingularFile($inputName, $i);
                $uploaded[] = $this->uploadFile($inputNameSingular, $config);
            }
        } catch (FileUploadException  $e) {
            foreach ($uploaded as $file) {
                $this->deleteFile($file);
            }
            throw $e;
        }

        return collect($uploaded);
    }

    private function buildSingularFile(string $inputName, int $i): array
    {
        return [
            'name' => $_FILES[$inputName]['name'][$i],
            'type' => $_FILES[$inputName]['type'][$i],
            'tmp_name' => $_FILES[$inputName]['tmp_name'][$i],
            'error' => $_FILES[$inputName]['error'][$i],
            'size' => $_FILES[$inputName]['size'][$i]
        ];
    }

    /**
     * @param string $fileName
     * @param array $config
     * @return FileDTO
     * @throws FileUploadException
     */
    private function uploadFile(string $fileName, array $config): FileDTO
    {
        $config = array_merge($this->defaultConfig, $config);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($fileName)) {
            return new FileDTO($this->upload->data());
        }

        throw new FileUploadException($this->upload->display_errors());
    }

    private function deleteFile(string $filePath): void
    {
        $this->load->helper("file");
        delete_files($filePath);
    }
}