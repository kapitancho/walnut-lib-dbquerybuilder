<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Expression\SqlExpression;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class QueryFilter {
	public function __construct(
		private readonly SqlExpression $sqlExpression
	) {}

	public function build(SqlQuoter $quoter): string {
		return $this->sqlExpression->build($quoter);
	}
}
