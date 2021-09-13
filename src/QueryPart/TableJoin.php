<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class TableJoin {
	private const JOIN_TEMPLATE = "%s JOIN %s %s ON %s";
	public function __construct(
		private /*readonly*/ string $tableAlias,
		private /*readonly*/ string $tableName,
		private /*readonly*/ QueryFilter $queryFilter,
		private /*readonly*/ bool $isLeftJoin = false
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(
			self::JOIN_TEMPLATE,
			$this->isLeftJoin ? 'LEFT' : '',
			$quoter->quoteIdentifier($this->tableName),
			$quoter->quoteIdentifier($this->tableAlias),
			$this->queryFilter->build($quoter)
		);
	}
}
