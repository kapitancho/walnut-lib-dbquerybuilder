<?php

namespace Walnut\Lib\DbQueryBuilder\Query;

use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class UpdateQuery {
	private const UPDATE_QUERY_TEMPLATE = "UPDATE %s SET %s WHERE %s";

	/**
	 * UpdateQueryBuilder constructor.
	 * @param string $tableName
	 * @param non-empty-array<string, SqlQueryValue> $values
	 * @param QueryFilter $queryFilter
	 */
	public function __construct(
		public readonly string $tableName,
		public readonly array $values,
		public readonly QueryFilter $queryFilter
	) {
		if (!count($this->values)) {
			throw new \InvalidArgumentException("An update query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$setList = [];
		foreach($this->values as $fieldName => $value) {
			$setList[] = $quoter->quoteIdentifier($fieldName) . ' = ' .
				$value->build($quoter);
		}
		return sprintf(self::UPDATE_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			implode(', ', $setList),
			$this->queryFilter->build($quoter)
		);
	}
}
