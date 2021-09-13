<?php

namespace Walnut\Lib\DbQueryBuilder\Query;

use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class InsertQuery {
	private const INSERT_QUERY_TEMPLATE = "INSERT INTO %s (%s) VALUES (%s)";

	/**
	 * InsertQueryBuilder constructor.
	 * @param string $tableName
	 * @param non-empty-array<string, SqlQueryValue> $values
	 */
	public function __construct(
		public /*readonly*/ string $tableName,
		public /*readonly*/ array $values
	) {
		if (!count($this->values)) {
			throw new \InvalidArgumentException("An insert query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$fieldList = [];
		$valueList = [];
		foreach($this->values as $fieldName => $value) {
			$fieldList[] = $quoter->quoteIdentifier($fieldName);
			$valueList[] = $value->build($quoter);
		}
		return sprintf(self::INSERT_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			implode(', ', $fieldList),
			implode(', ', $valueList)
		);
	}

}
