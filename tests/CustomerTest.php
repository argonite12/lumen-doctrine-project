<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use Laravel\Lumen\Testing\TestCase;



class CustomerTest extends TestCase
{

    use DatabaseMigrations;

    
    public function testShouldReturnCustomer()
    {

        $response = $this->get('/customer');
        return $response->seeJsonStructure([
            'fullname',
            'email',
            'country'
        ]);

    }

    public function testShouldReturnSpecificCustomer()
    {

        $response = $this->get('/customer/2');
        return $response->seeJsonStructure([
            'fullname',
            'email',
            'username',
            'gender',
            'country',
            'city',
            'phone'
        ]);

    }
}
