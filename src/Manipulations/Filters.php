<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Filters.
 *
 * @see \Beeyev\Thumbor\Thumbor::addFilter
 */
class Filters
{
    protected array $filters = [];

    public function addFilter(string $filterName, ...$args): Filters
    {
        $filterParams = '';
        if (isset($args[0]) && is_array($args[0])) {
            $filterParams = implode(',', $args[0]);
        }

        $this->filters[] = $filterName . "({$filterParams})";

        return $this;
    }

    public function getFilters(): ?string
    {
        if (empty($this->filters)) {
            return null;
        }

        return 'filters:' . implode(':', $this->filters);
    }

    public function noFilters(): Filters
    {
        return new static();
    }
}
