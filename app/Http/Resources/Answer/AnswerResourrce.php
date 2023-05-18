<?php

namespace App\Http\Resources\Answer;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResourrce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'answerText'=> $this->text,
            'isCorrect'=>($this->isCorrect )? true:false,
        ];
    }
}

