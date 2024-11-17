<?php


namespace Tools;

require_once 'vendor/autoload.php';

use Shuchkin\SimpleXLSXGen;

abstract class ExportAsExcel
{
    public const DEFAULT_COLUMNS = [
        "SN",
        "Name English",
        "Name Arabic",
        "DOB",
        "Nationality Arabic",
        "Nationality English",
        "Date of Expiry",
        "Blood Group",
        "MemberShip No",
        "QID Number"
    ];

    public array $columns = [
        "F_name_EN",
        "L_name_EN",
        "F_name_AR",
        "L_name_AR",
        "DOP",
        "Nationality",
        "r_countries.name_AR as nationality_ar",
        "National_Id_Expire",
        "r_blood_type.bloodtype_title_en as bloodType",
        "Regstration_No",
        "National_Id"
    ];
    public int $sn = 0;

    abstract public function data(): array;

    abstract public function filename(): string;

    abstract public function controller();

    public function query(): void
    {
        $this->controller()->load->library('session');
        $sessionData = $this->controller()->session->userdata('admin_details');

        $this->controller()->db->select(implode(",", $this->columns))->where("Added_By", $sessionData['admin_id'])
            ->join("r_blood_type", "r_blood_type.bloodtype_id = l2_student.blood_group")
            ->join("r_countries", "LOWER(r_countries.name) = LOWER(l2_student.Nationality)" , "LEFT")
            ->from("l2_student");
    }

    public function export(): bool
    {
        $data = array_map(function ($item) {
            return $this->formatData($item);
        }, $this->data());


        return SimpleXLSXGen::fromArray(array_merge([self::DEFAULT_COLUMNS], $data))->downloadAs($this->filename());
    }


    public function formatData(array $item): array
    {
        $this->sn++;
        return [
            $this->sn,
            $item['F_name_EN'] . " " . $item['L_name_EN'],
            $item['F_name_AR'] . " " . $item['L_name_AR'],
            $item['DOP'],
            $item['nationality_ar'],
            $item['Nationality'],
            $item['National_Id_Expire'],
            $item['bloodType'],
            $item['Regstration_No'],
            $item['National_Id'],
        ];
    }
}