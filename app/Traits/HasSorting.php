<?php

namespace App\Traits;

trait HasSorting
{
    public function scopeSortByField($query, $sortBy, $direction = 'desc')
    {
        if ($this->isSortableColumn($sortBy)) {
            return $query->orderBy($sortBy, $direction);
        }
        return $query->orderBy('id', 'desc');
    }

    private function isSortableColumn($sortBy): bool
    {
        return in_array($sortBy, $this->getSortableColumns(), true);
    }

    private function getSortableColumns()
    {
        if (property_exists($this, 'sortableColumns')) {
            return $this->sortableColumns;
        }
        return [];
    }
}
