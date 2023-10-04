<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        try {
            if (env('RESIZE_IMAGE') === true) {
                $image = $this->getMedia('*')[0]->getUrl('resized-image');
            } else {
                $image = $this->getMedia('*')[0]->getUrl();
            }
        } catch (Exception $e) {
//           error_log($e->getMessage());
            $image = "";
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'categories' => $this->categories()->select('id', 'name')->get(),
            'content' => substr($this->content, 0, 50) . '...',
            'image' => $image,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
