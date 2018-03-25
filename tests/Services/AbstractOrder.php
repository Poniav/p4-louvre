<?php

namespace App\Tests\Services;

use App\Services\OrderManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AbstractOrder extends TestCase
{
    /**
     * Instance of OrderManager Service
     * @return OrderManager
     */
    protected function getOrderManagerInstance()
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


    // Create date from format d/m/Y given
    protected function createDateFromFormat($date)
    {
        return \DateTime::createFromFormat('d/m/Y', $date);
    }


}