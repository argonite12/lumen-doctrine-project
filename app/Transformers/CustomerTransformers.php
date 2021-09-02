<?php

namespace App\Transformers;

use App\Entities\Customer;

class CustomerTransformers
{

    public function basicInfo(Customer $customer)
    {
        return [
            'fullname'  => $customer->getFullName(),
            'email'     => $customer->getEmail(),
            'country'   => $customer->getCountry()
        ];
    }

    public function fullInfo(Customer $customer)
    {
        return [
            'fullname'  => $customer->getFullName(),
            'email'     => $customer->getEmail(),
            'username'  => $customer->getUsername(),
            'gender'    => $customer->getGender(),
            'country'   => $customer->getCountry(),
            'city'      => $customer->getCity(),
            'phone'     => $customer->getPhone()
        ];
    }

    public function transformAll(array $customer)
    {
        return array_map(
            function ($customer) {
                return $this->basicInfo($customer);
            }, $customer
        );
    }

}
