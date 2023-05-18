<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\Answer\AnswerResourrce;
use App\Models\Answer;
use App\Models\QuestionPool;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResourrce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $answers = Answer::where('questionId', $this->id)->get();
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'questionText' => $this->Question,
            // 'questionImage' => ($this->image)? asset('images/Question_img/'.$this->image) : "",
            'answers' => ($answers) ? AnswerResourrce::collection($answers) : [] ,
        ];
    }
}

