<?php

namespace App\Tests\Entity;

use App\Entity\Tickets;
use PHPUnit\Framework\TestCase;

class TicketsTest extends TestCase
{
    /**
     * Test to get the Age of visitor between the date of birth and the date of visit
     * @dataProvider dateProvider
     * @param $birth
     * @param $expected
     * @param $dateBooking
     */
    public function testAgeDiffByDates($birth, $expected, $dateBooking)
    {
        $ticket = $this->getMockForAbstractClass(Tickets::class);

        $birth = $this->createDateFromFormat($birth);
        $dateBooking = $this->createDateFromFormat($dateBooking);

        $ticket->setBirth($birth);

        $this->assertNotNull($birth, $dateBooking);
        $this->assertEquals($expected, $ticket->getAge($dateBooking));
    }

    // Set date of birth - age expected at the visit - the date of the visit
    public function dateProvider()
    {
        return [
            ['17/03/1990', 29, '25/03/2019'],
            ['23/07/1974', 46, '12/09/2020'],
            ['11/02/1942', 83, '11/12/2025'],
            ['05/05/1964', 54, '02/08/2018'],
            ['16/04/2002', 16, '08/06/2018'],
            ['27/10/2014', 4, '03/01/2019']
        ];
    }


    // Create date from format d/m/Y given
    private function createDateFromFormat($date)
    {
        return \DateTime::createFromFormat('d/m/Y', $date);
    }

}
