<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQueryBuilder\Expression\RawExpression;
use Walnut\Lib\DbQueryBuilder\Query\DeleteQuery;
use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\DbQueryBuilder\Quoter\MysqlQuoter;

final class DeleteQueryTest extends TestCase {

	public function testOk(): void {
		$dqb = new DeleteQuery(
			"clients",
			new QueryFilter(new RawExpression("1"))
		);
		$this->assertEquals(
			"DELETE FROM `clients` WHERE 1",
			$dqb->build(new MysqlQuoter)
		);
	}

}