<?php


namespace Tests;

use Cleeng\Entitlements\Viewer;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{

    public function testViewerHaveAccesToResourceThatIsHisEnitltement()
    {
        $viewer = new Viewer([1], 0);

        $val = $viewer->haveAccessToResource(1);

        $this->assertTrue($val);
    }

    public function testViewerDoesNotHaveAccessToResourceThatIsNotHisEntitlement()
    {
        $viewer = new Viewer([], 0);

        $val = $viewer->haveAccessToResource(1);

        $this->assertFalse($val);
    }

}