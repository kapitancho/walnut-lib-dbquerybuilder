<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class OrderByField {
	private const FIELD_TEMPLATE = '%s %s';
	public function __construct(
		private readonly string $fieldName,
		private readonly OrderByDirection $orderByDirection,
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::FIELD_TEMPLATE,
			$quoter->quoteIdentifier($this->fieldName),
			$this->orderByDirection->value
		);
	}

	public static function ascending(string $fieldName): self {
		return new self($fieldName, OrderByDirection::ascending);
	}

	public static function descending(string $fieldName): self {
		return new self($fieldName, OrderByDirection::descending);
	}
}
