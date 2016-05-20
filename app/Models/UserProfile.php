<?php namespace App\Models;

use App\Models\Traits\HasOwner;
use Cache;
use Illuminate\Database\Eloquent\Model;
use TeamTeaTime\Filer\HasAttachments;
use Slynova\Commentable\Traits\Commentable;

class UserProfile extends Model
{
    use Commentable, HasAttachments, HasOwner;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'about', 'signature'];

    /**
     * User-friendly model name.
     *
     * @return string
     */
    public $friendlyName = 'User Profile';

    /**
     * Attribute: avatar.
     *
     * @return \TeamTeaTime\Filer\Attachment
     */
    public function getAvatarAttribute()
    {
        return Cache::remember("user_{$this->user->id}_avatar", 5, function () {
            return $this->findAttachmentByKey('avatar');
        });
    }

    /**
     * Attribute: avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return (is_null($this->avatar))
            ? config('user.default_avatar_path')
            : $this->avatar->getUrl();
    }

    /**
     * Attribute: URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('user.profile', ['id' => $this->user->id, 'name' => str_slug($this->user->name)]);
    }
}
