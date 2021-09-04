<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
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
            'trx_id'=> $this->trx_id,
            'ref_no'=> $this->ref_no,
            'amount'=> number_format($this->amount,2) . ' MMK',
            'type'=> $this->type,
            'date_time'=> Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'source'=> $this->source ? $this->source->name : '-',
            'description'=> $this->description,
        ];
    }
}
