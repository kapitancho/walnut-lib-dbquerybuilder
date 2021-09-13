<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class SelectLimit {
	public function __construct(
		private /*readonly*/ int $limit,
		private /*readonly*/ int $offset
	) {}

	public function build(): string {
		return "LIMIT $this->offset, $this->limit";
	}

	public static function forPage(int $page, int $pageSize): self {
		return new self($pageSize, ($page - 1) * $pageSize);
	}
}
