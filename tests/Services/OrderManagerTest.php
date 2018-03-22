<?php

namespace App\Tests\Services;

use App\Services\OrderManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderManagerTest extends TestCase
{

    /**
     * Test if age return the good price
     * @dataProvider priceRangeProvider
     * @param $expectedPrice
     * @param $age
     */
    public function testPriceRange($expectedPrice, $age)
    {
        $orderManger = $this->getOrderManagerInstance();
        $result = $orderManger->getPriceRange($age);

        $this->assertEquals($expectedPrice, $result);

    }

    // Set the expected price for the age
    public function priceRangeProvider()
    {
        return [
            [0, 3],
            [8, 8],
            [12, 82],
            [16, 54],
            [8, 12],
        ];
    }

    /**
     * @return OrderManager
     */
    private function getOrderManagerInstance()
    {
        $session = $this->getMockBuilder(SessionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $flashBag = $this->getMockBuilder(FlashBagInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $route = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stripekey = null;

        /** @var SessionInterface $session */
        /** @var FlashBagInterface $flashBag */
        /** @var UrlGeneratorInterface $route */
        /** @var EntityManagerInterface $em */
        $orderManager = new OrderManager($session, $flashBag, $route, $em, $stripekey);
        return $orderManager;
    }
}
