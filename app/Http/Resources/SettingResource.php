<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'aboutUs' => $this->about_us,
            'whyUs' => $this->why_us,
            'welcomeText' => $this->welcome_text,
            'homeText' => $this->home_text,
            'successText' => $this->success_text,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'email' => $this->email,
        ];
    }

}
