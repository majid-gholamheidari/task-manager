<?php

namespace App\Helpers;

class Paginator
{

    /**
     * Paginate Collection
     * @param $query
     * @return array
     */
    public static function paginate($query): array
    {
        $perPage = request('per_page', 15);
        $currentPage = request('page', 1);

        $items = $query
            ->skip( ($currentPage - 1) * $perPage )
            ->take($perPage)
            ->get();

        $totalItems = $query->count();

        return [
            'items' => $items,
            'meta' => [
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'total_page' => ceil($totalItems / $perPage),
                'total_items' => $totalItems,
            ]
        ];
    }
}
