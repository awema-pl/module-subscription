<?php

namespace AwemaPL\Subscription\Sections\Options\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EloquentOption extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' =>$this->price,
            'created_at' =>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
