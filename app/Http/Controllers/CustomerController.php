<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Transformers\CustomerTransformers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    

    public function index(EntityManagerInterface $eM)
    {
        // /customer; show all customer with selected info
        $customer = $eM->getRepository(Customer::class)
                    ->findAll();

        $transformer = new CustomerTransformers();
        return $transformer->transformAll($customer);

    }

    public function show($id, EntityManagerInterface $eM)
    {
        // /customer/{id} ; show all details of the customer

        $customer = $eM->getRepository(Customer::class)
                    ->findOneBy(['id' => $id]);

        if(!$customer)
            return response()->json(['results' => false], 201);

        $transformer = new CustomerTransformers();
        return $transformer->fullInfo($customer);
        
    }


}
