<?php

namespace Walnut\Lib\DbQueryBuilder\Query;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
interface Query {
	public function build(SqlQuoter $quoter): string;
}
