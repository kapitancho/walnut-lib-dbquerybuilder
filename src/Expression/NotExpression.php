<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class NotExpression implements SqlExpression {
	public function __construct(
		private /*readonly*/ SqlExpression $expression
	) {}
	public function build(SqlQuoter $quoter): string {
		return 'NOT (' . $this->expression->build($quoter) . ')';
	}
}
