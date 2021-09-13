<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQueryBuilder\Query\InsertQuery;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\DbQueryBuilder\Quoter\MysqlQuoter;

final class InsertQueryTest extends TestCase {

	public function testOk(): void {
		$iqb = new InsertQuery(
			"clients", [
				"id" => new SqlValue(7),
				"name" => new SqlValue('Client 7')
			]
		);
		$this->assertEquals(
			"INSERT INTO `clients` (`id`, `name`) VALUES (7, 'Client 7')",
			$iqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new InsertQuery("clients", []);
	}

}