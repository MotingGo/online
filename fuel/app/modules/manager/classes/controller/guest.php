<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/31
 * Time: 23:48
 */

namespace manager;


class Controller_Guest extends Controller_Home
{
    /**
     * 访客用户
     * @return \Fuel\Core\View
     */
    public function action_index()
    {
        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('guest/index');

        $guests = \Model_Guest::query()
            ->get();

        $view->guests = $guests;

        return $view;
    }

    /**
     * 黑名单
     * @return mixed
     */
    public function action_blacklist()
    {
        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('guest/blacklist');

        $view->blacklists = \Model_Guest::query()
            ->where([
                'is_blacklist' => 1
            ])
            ->get();

        return $view;
    }

    /**
     * 访客用户-管理（修改）
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function put_index($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $data = \Input::put();

        $guest = \Model_Guest::find($id);

        $guest->set($data);

        $guest->save();

        return $this->result;
    }
}