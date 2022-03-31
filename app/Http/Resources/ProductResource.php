<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'category'    => $this->categories->category ?? '',
            'category_id' => $this->category_id,
            'formatDateAdded' => $this->DateCreated,
            'date_added'  => $this->DateTime,
            'attachments' => $this->attachments ?? ''
        ];
    }
}
