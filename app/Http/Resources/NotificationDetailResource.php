<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'date_time'=>Carbon::parse($this->created_at)->format('Y-m-d H:i:s A'),
            'deep_link'=> $this->deep_link,
        ];
    }
}
