<?php

namespace App\Models;

use FFI\Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clicks;
use Str;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shortpath',
        'tourl',
        'password',
        'premium',
        'delete_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
            $link->shortpath = self::generateUniqueShortpath();
        });
    }

    private static function generateUniqueShortpath($maxAttempts = 1000)
    {
        $attempts = 0;
        do {
            $shortpath = Str::random(4);
            $attempts++;
            if ($attempts > $maxAttempts) {
                throw new Exception('All possible 4-character shortpaths have been used.');
            }
        } while (Link::where('shortpath', $shortpath)->exists());

        return $shortpath;
    }

    public function clicks()
    {
        return $this->hasMany(Clicks::class);
    }

    public function newClick()
    {
        return Clicks::create([
            'link_id' => $this->id
        ]);
    }

    public function getFullURL(): string
    {
        return $this->premium ? env('PREMIUM_LINKS_URL') . '/' . $this->shortpath : env('NORMAL_LINKS_URL') . '/' . $this->shortpath;
    }
}
