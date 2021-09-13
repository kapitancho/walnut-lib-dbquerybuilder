<?php

namespace Walnut\Lib\DbQueryBuilder\QueryValue;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class PreparedValue implements SqlQueryValue {
	public function __construct(private /*readonly*/ string $parameterName) {}

	public function build(SqlQuoter $quoter): string {
		return ":$this->parameterName";
	}
}
