<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/3/26
 * Time: 0:32
 */

namespace manager;


class Controller_Message extends Controller_Home
{

    /**
     * 留言信息-管理页面
     * @return \Fuel\Core\View
     */
    public function action_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $view = \View::forge('message/index');

        $query = \Model_Comment::query()
            ->where([
                'parent_id' => 0,
                'is_deleted' => 0,
            ])
            ->order_by([
                'display_at' => 'DESC'
            ]);

        if($keyword = \Input::get('keyword')){
            $query->where([
                ['content', 'LIKE', "%{$keyword}%"]
            ]);
        }
        $view->comments = $query->get();

        $view->keyword = $keyword;

        return $view;
    }

    /**
     * 修改【信息修改】
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function put_index($id = 0){

        if ( ! $this->flag){
            return $this->result;
        }

        $comment = \Model_Comment::find($id);

        if (!$comment){
            return $this->result = [
                'status' => 'err',
                'msg' => '未找到',
                'errcode' => 10,
            ];
        }
        $data = \Input::put();

        $comment->set($data);

        $comment->save();

        return $this->result;
    }

    /**
     * 删除【信息删除】
     * @return array
     * @throws \Exception
     */
    public function delete_index(){

        if ( ! $this->flag){
            return $this->result;
        }

        $id = \Input::delete('id');

        $comment = \Model_Comment::find($id);

        $comment->is_deleted = 1;

        $comment->save();

        return $this->result;
    }
}