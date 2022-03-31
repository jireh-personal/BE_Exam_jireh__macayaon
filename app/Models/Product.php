<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','category_id','description','date_added','user_id'
    ];

    public function categories()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function getDateCreatedAttribute()
    {
        return date('F d, Y h:i a',strtotime($this->date_added));
    }
    public function getDateTimeAttribute()
    {
        return date('Y-m-d\TH:i',strtotime($this->date_added));
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class,'attachable');
    }
}
