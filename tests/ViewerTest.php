<?php


namespace Tests;

use Cleeng\Entitlements\NoAccessStrategy;
use Cleeng\Entitlements\Viewer;
use PHPUnit\Framework\TestCase;

class ViewerTest extends TestCase
{

    public function testViewerHaveAccessResourceThatIsHisEnitltement()
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

    public function testProvidingStrategyToViewerWillOverideDefaultPolicy()
    {
        $viewer = new Viewer([1], 0);

        $val = $viewer->haveAccessToResource(1, new NoAccessStrategy());

        $this->assertFalse($val);
    }
}