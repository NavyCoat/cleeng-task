<?php


namespace Tests;

use Cleeng\Entitlements\Domain\ResourcesAccessStrategy;
use Cleeng\Entitlements\Domain\Viewer;
use DateTime;
use PHPUnit\Framework\TestCase;

class ViewerTest extends TestCase
{

    public function testViewerHaveAccessResourceThatIsHisEnitltement()
    {
        $viewer = new Viewer(2);
        $viewer->addEntitlement(1);

        $val = $viewer->haveAccessToResource(1, new DateTime());

        $this->assertTrue($val);
    }

    public function testViewerDoesNotHaveAccessToResourceThatIsNotHisEntitlement()
    {
        $viewer = new Viewer(2);

        $val = $viewer->haveAccessToResource(1, new DateTime());

        $this->assertFalse($val);
    }

    public function testViewerHaveAccessResourceToAddedEntitlement()
    {
        $viewer = new Viewer(2);
        $viewer->addEntitlement(1);

        $val = $viewer->haveAccessToResource(1, new DateTime());

        $this->assertTrue($val);
    }

    public function testProvidingStrategyToViewerWillOverideDefaultPolicy()
    {
        $viewer = new Viewer(2);
        $viewer->addEntitlement(1);

        $strategy = $this->createMock(ResourcesAccessStrategy::class);
        $strategy
            ->expects($this->once())
            ->method('haveAccessToResource')
            ->willReturn(false);


        $val = $viewer->haveAccessToResource(1, new DateTime(), $strategy);

        $this->assertFalse($val);
    }
}