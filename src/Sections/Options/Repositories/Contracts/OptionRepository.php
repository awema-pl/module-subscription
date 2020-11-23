<?php

namespace AwemaPL\Subscription\Sections\Options\Repositories\Contracts;

use Illuminate\Http\Request;

interface OptionRepository
{
    /**
     * Create option
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Scope option
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);

    /**
     * Update membership
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);

    /**
     * Delete membership
     *
     * @param int $id
     */
    public function delete($id);
}
