<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderControllerTest extends WebTestCase
{

    /**
     * Test accessible pages
     * @dataProvider urlProviderSuccessful
     * @param $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     * Test Not Found pages
     * @dataProvider urlProviderNotFound
     * @param $url
     */
    public function testNotFoundPages($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

//        $this->expectException(NotFoundHttpException::class);

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    // Provide list of Successful pages
    public function urlProviderSuccessful()
    {
        yield ['/'];
        yield ['/cgv'];
        yield ['/cgu'];
        yield ['/contact'];
    }

    // Provide list of NotFound pages outside the booking workflow
    public function urlProviderNotFound()
    {
        return [
            ['/billet'],
            ['/paiement'],
            ['confirmation/3']
        ];
    }

//     Test Functional Booking WorkFlow

    public function testBookingForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $formBooking = $crawler->selectButton('submit')->form();

        $formBooking['booking[firstname]'] = 'Guillaume';
        $formBooking['booking[lastname]'] = 'Garcia';
        $formBooking['booking[email]'] = 'macadition@gmail.com';
        $formBooking['booking[date]'] = '21/03/2019';
        $formBooking['booking[type]'] = 1;
        $formBooking['booking[number]'] = 2;

        $crawler = $client->submit($formBooking);

        $this->assertTrue($client->getResponse()->isRedirect('/billet'));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Vos billets")')->count());

        $formTickets = $crawler->selectButton('submit')->form();

        $formTickets['ticket_collection[tickets][0][firstname]'] = 'Guillaume';
        $formTickets['ticket_collection[tickets][0][lastname]'] = 'Garcia';
        $formTickets['ticket_collection[tickets][0][birth]'] = '17/03/1990';
        $formTickets['ticket_collection[tickets][0][country]'] = 'FR';

        $formTickets['ticket_collection[tickets][1][firstname]'] = 'Nicolas';
        $formTickets['ticket_collection[tickets][1][lastname]'] = 'Etienne';
        $formTickets['ticket_collection[tickets][1][birth]'] = '17/03/1978';
        $formTickets['ticket_collection[tickets][1][country]'] = 'FR';
        $formTickets['ticket_collection[tickets][1][discount]'] = 1;

        $crawler = $client->submit($formTickets);

        $this->assertTrue($client->getResponse()->isRedirect('/paiement'));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Récapitulatif")')->count());

        $this->assertTrue($client->getResponse()->isSuccessful());

    }



}
