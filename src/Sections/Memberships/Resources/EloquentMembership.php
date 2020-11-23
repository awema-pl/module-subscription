<?php

namespace AwemaPL\Subscription\Sections\Memberships\Resources;

use AwemaPL\Subscription\Sections\Options\Resources\EloquentOption;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EloquentMembership extends JsonResource
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
            'user' => new EloquentUser($this->user),
            'option' => new EloquentOption($this->option),
            'expires_at' =>$this->expires_at->format('Y-m-d H:i:s'),
            'has_expired' => $this->expires_at->lte(now()),
            'comment' => $this->comment,
            'created_at' =>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
