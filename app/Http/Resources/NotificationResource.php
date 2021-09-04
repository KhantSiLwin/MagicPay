<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'=>$this->id,
            'title' =>Str::limit($this->data['title'],40),
            'message' => Str::limit($this->data['message'],100),
            'date_time' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s A'),
            'read' => is_null($this->read_at) ? 1:0,
        ];
    }
}
