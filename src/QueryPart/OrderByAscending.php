<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class OrderByAscending {
	public function __construct(
		private /*readonly*/ string $fieldName
	) {}

	public function build(SqlQuoter $quoter): string {
		return $quoter->quoteIdentifier($this->fieldName) . ' ASC';
	}
}
