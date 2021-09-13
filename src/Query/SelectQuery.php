<?php

namespace Walnut\Lib\DbQueryBuilder\Query;

use Walnut\Lib\DbQueryBuilder\QueryPart\OrderByAscending;
use Walnut\Lib\DbQueryBuilder\QueryPart\OrderByDescending;
use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryPart\SelectLimit;
use Walnut\Lib\DbQueryBuilder\QueryPart\TableField;
use Walnut\Lib\DbQueryBuilder\QueryPart\TableJoin;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class SelectQuery {
	private const SELECT_QUERY_TEMPLATE = "SELECT %s FROM %s AS _ %s WHERE %s %s %s";

	/**
	 * UpdateQueryBuilder constructor.
	 * @param string $tableName
	 * @param non-empty-array<string, string|SqlQueryValue|TableField> $fields
	 * @param list<TableJoin> $joins
	 * @param QueryFilter $queryFilter
	 * @param list<OrderByAscending|OrderByDescending> $orderBy
	 * @param SelectLimit|null $selectLimit
	 */
	public function __construct(
		public /*readonly*/ string $tableName,
		public /*readonly*/ array $fields,
		public /*readonly*/ array $joins,
		public /*readonly*/ QueryFilter $queryFilter,
		public /*readonly*/ array $orderBy = [],
		public /*readonly*/ ?SelectLimit $selectLimit = null
	) {
		if (!count($this->fields)) {
			throw new \InvalidArgumentException("A select query must have at least one value specified");
		}
	}

	public function build(SqlQuoter $quoter): string {
		$fieldList = [];
		foreach($this->fields as $alias => $fieldName) {
			$fieldList[] = $alias === $fieldName ?
				"_." . $quoter->quoteIdentifier($fieldName) :
				sprintf("%s AS %s",
					(($fieldName instanceof SqlQueryValue) ||
							($fieldName instanceof TableField)) ?
						$fieldName->build($quoter) :
						"_." . $quoter->quoteIdentifier($fieldName),
					$quoter->quoteIdentifier($alias)
				);
		}
		$joinList = [];
		foreach($this->joins as $join) {
			$joinList[] = $join->build($quoter);
		}

		$orderByList = [];
		foreach($this->orderBy as $orderByField) {
			$orderByList[] = $orderByField->build($quoter);
		}
		return sprintf(self::SELECT_QUERY_TEMPLATE,
			implode(', ', $fieldList),
			$quoter->quoteIdentifier($this->tableName),
			implode('', $joinList),
			$this->queryFilter->build($quoter),
			$orderByList ? "ORDER BY " . implode(', ', $orderByList) : '',
			$this->selectLimit?->build() ?? ''
		);
	}
}
