<?php

namespace Walnut\Lib\DbQueryBuilder\QueryValue;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class PlaceholderValue implements SqlQueryValue {
	public function __construct(private /*readonly*/ string $placeholderName) {}

	public function build(SqlQuoter $quoter): string {
		return "**__" . $this->placeholderName . "__**";
	}
}
