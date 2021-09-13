<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQueryBuilder\Expression\RawExpression;
use Walnut\Lib\DbQueryBuilder\Query\UpdateQuery;
use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\DbQueryBuilder\Quoter\MysqlQuoter;

final class UpdateQueryTest extends TestCase {

	public function testOk(): void {
		$uqb = new UpdateQuery(
			"clients", [
				"id" => new PreparedValue('id'),
				"name" => new SqlValue('Client 7')
			],
			new QueryFilter(new RawExpression("1"))
		);
		$this->assertEquals(
			"UPDATE `clients` SET `id` = :id, `name` = 'Client 7' WHERE 1",
			$uqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new UpdateQuery("clients", [],
			new QueryFilter(new RawExpression("1")));
	}

}