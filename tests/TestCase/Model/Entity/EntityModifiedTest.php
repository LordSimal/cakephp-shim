<?php

namespace Shim\Test\TestCase\Model\Entity;

use Shim\TestSuite\TestCase;
use TestApp\Model\Entity\TestEntity;

class EntityModifiedTest extends TestCase {

	/**
	 * @return void
	 */
	public function testGetModifiedFields(): void {
		$entity = new TestEntity(['foo' => 'foo', 'bar' => 'bar'], ['markClean' => true, 'markNew' => false]);

		$entity->set('foo', 'foo');
		$entity->set('foo_bar', 'foo bar');

		$result = $entity->getDirty();
		$expected = ['foo', 'foo_bar'];
		$this->assertSame($expected, $result);

		$result = $entity->getModifiedFields();
		$expected = ['foo_bar'];
		$this->assertSame($expected, $result);
	}

}