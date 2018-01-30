<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //获取gravatar头像
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /*发送定制重置密码邮件
     * @return string
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /*指明一个用户拥有多条微博 返回该用户所有动态。
     * @return array
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /*将当前用户发布过的所有微博从数据库中取出，并根据创建时间来倒序排序。
     * 将使用该方法来获取当前用户关注的人发布过的所有微博动态
     * @return array
     */
    public function feed()
    {
        return $this->statuses()->orderBy('id', 'desc');
    }


    /* follower_id  是关注者id
    * user_id      是被关注者id
    * 以第四个参数，去查第三个参数
    */

    /*  belongsToMany 来关联模型之间的多对多关系
     *  获取 粉丝列表
     * follower_id 是关注者的id，user_id 是被关注用户id
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    /*
     *获取 我的关注   user_id
     */
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    /*
     * 关注操作
     * sync 方法会接收两个参数
     * 第一个参数为要进行添加的 id
     * 第二个参数则指明是否要移除其它不包含在关联的 id 数组中的 id，
     * true 表示移除，false 表示不移除，默认值为 true
     */
    public function follow($user_ids)
    {
        if(!array($user_ids)){
            $user_ids = compact($user_ids);
        }

        $this->followings()->sync($user_ids, false);
    }

    //取消关注
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        //判断我的关注中是否有这个user_id 有不做操作，没有就添加一条
        $this->followings()->detach($user_ids);
    }

    //判断当前用户的列表上是否包含传递进来的用户id
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }



}
