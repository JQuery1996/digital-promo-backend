<?php

namespace App\Http\Resources\Question;

use App\Models\LevelMetaData;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Extension\CommonMark\Parser\Block\ThematicBreakStartParser;

class QuestionPoolResourrce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $questions = Question::where('questionPoolId',$this->id)->get();
        $question_arr =[];
        foreach($questions as $question){

            array_push($question_arr,$question->id);
        }
        $randoumQuestions_arr =[];

        $metaData = LevelMetaData::where('levelId',$request->levelId)
        ->where('key','questionsCount')->first();


       $questionsCount = min((integer)$metaData->value,count($questions));
       $index = 0 ;
       while($index < $questionsCount) {
            $current = $question_arr[array_rand($question_arr)];
            if(!in_array($current,$randoumQuestions_arr)) {
                array_push($randoumQuestions_arr,$current);
                $index += 1;
            }
       }
        // for ($i=0; $i <$questionsCount ; $i++) {
        //     while(!in_array(($current = $question_arr[array_rand($question_arr)]), $randoumQuestions_arr)){

        //         array_push($randoumQuestions_arr,$current);
        //         break;

        //     }


        // }

        $questions = Question::whereIn('id',$randoumQuestions_arr)->get();


        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'questionPoolId'=> $this->id,
            'questionPoolName'=> $this->name,
            'questions'=> ($questions)? QuestionResourrce::collection($questions) : [] ,
        ];
    }
}

