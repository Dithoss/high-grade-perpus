<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class QueryFilterHelper
{
    public static function applyFilters(
        Builder $query,
        array $filters,
        array $searchColumns = []
    ): Builder {

        if (!empty($filters['search']) && $searchColumns) {
            $search = $filters['search'];

            $query->where(function ($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $column) {
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column);
                        $q->orWhereHas($relation, fn ($r) =>
                            $r->where($field, 'like', "%{$search}%")
                        );
                    } else {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

        if ($filters['stock_min'] ?? false) {
            $query->where('stock', '>=', (int) $filters['stock_min']);
        }

        if ($filters['stock_max'] ?? false) {
            $query->where('stock', '<=', (int) $filters['stock_max']);
        }

        if ($filters['category_id'] ?? false) {
            $query->where('category_id', $filters['category_id']);
        }

        if ($filters['date_from'] ?? false) {
            $query->where('created_at', '>=', self::parseDate($filters['date_from'], false));
        }

        if ($filters['date_to'] ?? false) {
            $query->where('created_at', '<=', self::parseDate($filters['date_to'], true));
        }

        return $query;
    }

    public static function applySorting(
        Builder $query,
        array $filters,
        string $defaultSort = 'created_at',
        string $defaultDirection = 'desc'
    ): Builder {
        $sortBy = $filters['sort_by'] ?? $defaultSort;
        $direction = strtolower($filters['sort_dir'] ?? $defaultDirection);

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = $defaultDirection;
        }

        return $query->orderBy($sortBy, $direction);
    }

    protected static function parseDate(string $date, bool $end): string
    {
        return Carbon::parse($date)
            ->{$end ? 'endOfDay' : 'startOfDay'}();
    }
}
