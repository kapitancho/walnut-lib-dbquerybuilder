<?php

namespace Walnut\Lib\DbQueryBuilder\Query;

use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class DeleteQuery {
	private const DELETE_QUERY_TEMPLATE = "DELETE FROM %s WHERE %s";
	public function __construct(
		public /*readonly*/ string $tableName,
		public /*readonly*/ QueryFilter $queryFilter
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::DELETE_QUERY_TEMPLATE,
			$quoter->quoteIdentifier($this->tableName),
			$this->queryFilter->build($quoter)
		);
	}
}
