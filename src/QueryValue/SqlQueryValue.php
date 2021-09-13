<?php

namespace Walnut\Lib\DbQueryBuilder\QueryValue;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
interface SqlQueryValue {
	public function build(SqlQuoter $quoter): string;
}
