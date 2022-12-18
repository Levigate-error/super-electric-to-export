<?php

namespace App\Models\Loyalty;

use App\Collections\Loyalty\GiftsCollection;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use App\Traits\HasExternalEntity;

class Gift extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasExternalEntity;

    protected $fillable = ['title', 'description', 'point', 'count', 'image', 'completed'];


    public function toArray(){
        $array = parent::toArray();
        $array['image_url'] = $this->image != null ? config('app.url').'/storage/'.$this->image : null;
        return $array;
    }
}
