<?php

namespace App\Http\Resources;

use App\Http\Resources\SlideMedia as SlideMediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideModal extends JsonResource
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
            '__option_autoplay' => true,
            '__option_controls' => true,
            '__option_controls_light' => true,
            '__option_inset' => false,
            '__option_caption' => false,
            '__option_loop' => false,
            'id' => $this->id,
            '__mediaType' => $this->modal_type,
            'src' => SlideMediaResource::collection($this->experienceImage)->toArray(request()),
            'caption' => 'This is an example caption',
            'poster' => 'ead4b67d-941c-4281-8c77-e2a3d9ed86ae',
        ];
    }
}
