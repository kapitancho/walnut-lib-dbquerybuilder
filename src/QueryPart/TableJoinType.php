<?php

namespace Walnut\Lib\DbQueryBuilder\QueryPart;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
enum TableJoinType: string {
	case innerJoin = 'JOIN';
	case leftJoin = 'LEFT JOIN';
}
