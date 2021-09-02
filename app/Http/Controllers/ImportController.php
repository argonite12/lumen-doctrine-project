<?php

namespace App\Http\Controllers;

use App\Entities\Customer;

class ImportController extends Controller
{

    protected $results;

    protected $country;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($results=10, $country='All')
    {
        $this->results = $results;
        $this->country = $country;
    }


    public function import_customer($eM)
    {
        $DataCountry = '';
        if($this->country != 'All')
            $DataCountry = '&nat='.$this->country;
        
        //Get Data Info from 3rd Party
        $customer_info = json_decode(
                                    file_get_contents('https://randomuser.me/api/?results='.$this->results.$DataCountry),
                                    true
                                );

        $customer_info = $customer_info['results'];

        //Extract Data
        foreach($customer_info as $info)
        {
            if($info['nat'] == 'AU')
            {
                $CheckCustomer = $this->checkUserEmail($info['email'],$eM);

                if( ! $CheckCustomer )
                {
                    //Insert
                    $customers = new Customer(
                                        $info['name']['first'],
                                        $info['name']['last'],
                                        $info['email'],
                                        $info['login']['username'],
                                        md5($info['login']['password']),
                                        $info['gender'],
                                        $info['location']['country'],
                                        $info['location']['city'],
                                        $info['phone']
                                    );
                }
                else
                {
                    //Update
                    $customers = $CheckCustomer;
                    $customers->setFirst($info['name']['first']);
                    $customers->setLast($info['name']['last']);
                    $customers->setUsername($info['login']['username']);
                    $customers->setPassword(md5($info['login']['password']));
                    $customers->setGender($info['gender']);
                    $customers->setCountry($info['location']['country']);
                    $customers->setCity($info['location']['city']);
                    $customers->setPhone($info['phone']);
                }

                $eM->persist($customers);
            }

        }

        $eM->flush();

        return response()->json(['results' => true], 201);
        
    }

    protected function checkUserEmail($email,$eM)
    {
        $customer   = $eM->getRepository(Customer::class)
                        ->findOneBy(['email' => $email]);

        return $customer;
    }

    //
}
