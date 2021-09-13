<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class TableField {
	private const SQL_TEMPLATE = "%s.%s";
	public function __construct(
		private /*readonly*/ string $tableAlias,
		private /*readonly*/ string $fieldName
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::SQL_TEMPLATE,
			$quoter->quoteIdentifier($this->tableAlias),
			$quoter->quoteIdentifier($this->fieldName)
		);
	}
}
