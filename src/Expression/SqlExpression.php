<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
interface SqlExpression {
	public function build(SqlQuoter $quoter): string;
}
