<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerRepository implements IRepository
{
    /**
     * Get customer by ID
     *
     * @param integer $id
     * @throws ModelNotFoundException
     * @return User
     */
    public function getByID(int $id) : Customer
    {
        return Customer::findOrFail($id);
    }

    public function get(int $page, int $limit, $enabledFilter = null) : Collection
    {
        $offset = ($page - 1) * $limit;
        
        $customerQuery = Customer::select();

        if (!is_null($enabledFilter)) {
            $enabledFilter = filter_var($enabledFilter, FILTER_VALIDATE_BOOLEAN);
            $customerQuery = $customerQuery->where('enabled', $enabledFilter);
        }
        
        return $customerQuery->orderBy('name', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * @return Customer
     */
    public function create(array $data) : Customer
    {
        $customer = new Customer();
        $customer->fill($data);
        $customer->save();

        return $customer;
    }

    /**
     * @throws ModelNotFoundException
     * @return Customer
     */
    public function update(int $id, array $data) : Customer
    {
        $customer = Customer::findOrFail($id);
        $customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function deleteById(int $id) : void
    {
        Customer::destroy($id);
    }

    public function getValidatorRules($name) : array
    {
        return (new Customer())->getValidatorRules($name);
    }
}