<?php

namespace App\Tests\Services;

use App\Entity\Booking;
use App\Entity\Tickets;

class OrderManagerTest extends AbstractOrder
{

    /**
     * Test Price Tickets by type, date of booking, birth date and discount special ticket
     * @dataProvider dataTicketProvider
     * @param $expectedPrice
     * @param $type
     * @param $date
     * @param $birth
     * @param $discount
     */
    public function testSetPriceTickets($expectedPrice, $type, $date, $birth, $discount)
    {
        $orderManger = $this->getOrderManagerInstance();
        $booking = new Booking();
        $booking->setType($type);
        $date = $this->createDateFromFormat($date);
        $booking->setDate($date);
        $ticket = new Tickets();
        $birth = $this->createDateFromFormat($birth);
        $ticket->setBirth($birth);
        $ticket->setDiscount($discount);
        $booking->addTicket($ticket);

        $orderManger->setPriceTickets($booking);

        $this->assertEquals($expectedPrice, $ticket->getPrice());
    }

    // Set the expected price for the age
    // $expectedPrice - $type - $date - $birth - $discount
    // type Booking FULLDAY or HALFDAY
    // discount Ticket special price
    public function dataTicketProvider()
    {
        return [
            [16, 1, '29/03/2018', '17/03/1990', 0],
            [5, 0, '29/03/2018', '17/03/1990', 1],
            [0, 1, '07/08/2019', '26/01/2017', 0],
            [4, 0, '18/12/2020', '04/05/2009', 0],
            [12, 1, '11/09/2019', '21/06/1950', 0],
        ];
    }


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

}
