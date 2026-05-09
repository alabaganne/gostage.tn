<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$user = auth()->user();
		$isCompany = $user->isCompany();
		$isStudent = $user->isStudent();

        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'cover_letter' => $this->cover_letter,
            'message' => $this->message,
            'attachments' => $this->attachments ?: [],
            'internship' => [
                'id' => $this->internship->id,
                'title' => $this->internship->title,
                'field' => [
					'name' => $this->internship->field->name,
				],
				'city' => [
					'name' => $this->internship->city->name,
				],
                'closing_at' => $this->internship->closing_at->format('F d, Y'),
            ],
            'student' => $isCompany ? [
                'name' => $this->student->user->name,
                'email' => $this->student->user->email,
                'image' => $this->student->user->image,
            ] : null,
            'company' => $isStudent ? [
                'name' => $this->company->user->name,
            ] : null,
            'created_at' => $this->created_at->format('F d, Y'),
        ];

        return $data;
    }
}
