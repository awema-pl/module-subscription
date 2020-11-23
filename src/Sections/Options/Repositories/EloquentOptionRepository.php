<?php

namespace AwemaPL\Subscription\Sections\Options\Repositories;

use AwemaPL\Subscription\Sections\Options\Models\Option;
use AwemaPL\Subscription\Sections\Options\Repositories\Contracts\OptionRepository;
use AwemaPL\Subscription\Sections\Options\Scopes\EloquentOptionScopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;

class EloquentOptionRepository extends BaseRepository implements OptionRepository
{
    protected $searchable = [

    ];

    public function entity()
    {
        return Option::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentOptionScopes($request))->scope($this->entity);

        return $this;
    }

    /**
     * Create new role
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Option::create($data);
    }

    /**
     * Update option
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     *
     * @return int
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        return parent::update($data, $id, $attribute);
    }

    /**
     * Delete option
     *
     * @param int $id
     */
    public function delete($id){
        $this->destroy($id);
    }
}
