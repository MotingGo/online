<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/31
 * Time: 11:32
 */

class Controller_Guest extends Controller_Home
{
    /**
     * 游客注册
     * @return array
     * @throws Exception
     */
    public function post_register()
    {
        $avatar_id = \Input::post('avatar_id');
        $nickname = \Input::post('nickname');

        $guest = Model_Guest::forge([
            'avatar_id' => $avatar_id,
            'nickname' => $nickname,
        ]);

        $guest->save();

        $guest->user_key = md5("guest_id={$guest->id}&time={$guest->created_at}");

        $guest->save();

        \Cookie::set('user_key', $guest->user_key, 2592000); // 3600 * 24 * 30

        return $this->result;
    }

    /**
     * 提交评论
     * @return array
     * @throws Exception
     */
    public function post_comment(){

        $data = \Input::post();

        $user_key = \Fuel\Core\Cookie::get('user_key');

        $guest = Model_Guest::query()
            ->where([
                'user_key' => $user_key
            ])
            ->get_one();

        $comment = Model_Comment::forge($data);
        $comment->user_id = $guest->id;
        $comment->display_at = time();

        $comment->save();

        $this->result['data'] = [
            'id' => $comment->id,
            'content' => $comment->content,
            'display_at' => $comment->display_at,
            'avatar' => $comment->guest->avatar->url,
            'nickname' => $comment->guest->nickname,
        ];

        return $this->result;
    }

    /**
     * 提交回复
     * @return array
     * @throws Exception
     */
    public function post_reply(){

        $data = \Input::post();

        $user_key = \Fuel\Core\Cookie::get('user_key');

        $guest = Model_Guest::query()
            ->where([
                'user_key' => $user_key
            ])
            ->get_one();

        $comment = Model_Comment::forge($data);
        $comment->parent_id = $data['parent_key'];
        $comment->user_id = $guest->id;
        $comment->display_at = time();

        $comment->save();

        $this->result['data'] = [
            'id' => $comment->id,
            'content' => $comment->content,
            'display_at' => $comment->display_at,
            'avatar' => $comment->guest->avatar->url,
            'nickname' => $comment->guest->nickname,
        ];

        return $this->result;
    }

    /**
     * 辅助操作 - 清空cookie
     * @return array
     */
    public function get_out_key(){

        $this->result['data'] = [
            'user_key' => \Fuel\Core\Cookie::get('user_key'),
        ];
        \Fuel\Core\Cookie::delete('user_key');
        return $this->result;
    }

    /**
     * 设置用户key以保持用户的登陆状态
     * @return array
     */
    public function get_set_key(){

        $user_key = \Input::get('user_key', false);

        if ( ! $user_key){
            return $this->result = [
                'status' => 'err',
                'msg' => '缺少标识',
                'errcode' => 10
            ];
        }

        $guest = \Model_Guest::query()
            ->where([
                'is_deleted' => 0,
                'user_key' => $user_key
            ])
            ->get_one();

        if ( ! $guest){
            return $this->result = [
                'status' => 'err',
                'msg' => '用户未找到',
                'errcode' => 10
            ];
        }

        \Fuel\Core\Cookie::set('user_key', $guest->user_key, 2592000);

        return $this->result;
    }


}