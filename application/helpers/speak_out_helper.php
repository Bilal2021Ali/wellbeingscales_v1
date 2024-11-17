<?php
if (!function_exists('all_priorities')) {
    function all_priorities(): array
    {
        return [
            0 => [
                'name' => 'Low',
                'bg' => '#5b73e8'
            ],
            1 => [
                'name' => 'Average',
                'bg' => '#f1b44c'
            ],
            2 => [
                'name' => 'High',
                'bg' => '#f46a6a'
            ]
        ];
    }
}

if (!function_exists('all_statuses')) {
    function all_statuses(): array
    {
        return [
            1 => [
                'name' => 'Pending',
                'bg' => '#01aff3'
            ],
            2 => [
                'name' => 'Seen',
                'bg' => '#c00000'
            ],
            3 => [
                'name' => 'Resolved',
                'bg' => '#ff4f4f'
            ],
            4 => [
                'name' => 'Approved',
                'bg' => '#fe0000'
            ],
        ];
    }
}

if (!function_exists('status')) {
    function status($status): array
    {
        $statusesList = all_statuses();
        $status = intval($status);

        if (isset($statusesList[$status])) {
            $result = $statusesList[$status];
            $result['text'] = $result['name'];
            return $result;
        }

        return [
            'name' => 'Unknown',
            'text' => 'unknown',
            'bg' => 'gray',
        ];
    }
}

if (!function_exists('priority')) {
    function priority($priority): array
    {
        $prioritiesList = all_priorities();
        $priority = intval($priority);
        if (isset($prioritiesList[$priority])) {
            $result = $prioritiesList[$priority];
            $result['text'] = $result['name'];
            return $result;
        }

        return [
            'name' => 'Unknown',
            'text' => 'unknown',
            'bg' => 'gray',
        ];
    }
}