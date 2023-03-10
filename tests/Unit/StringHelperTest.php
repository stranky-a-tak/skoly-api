<?php

namespace Tests\Unit;

use App\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function test_slugging_a_name()
    {
        $name = "FIIT STU";
        $slug = StringHelper::sluggable($name);

        $this->assertEquals('fiit-stu', $slug);
    }
}
