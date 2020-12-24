<?php
namespace app\course\controller;
use app\model\CourseModel;
use think\Db;
use think\Controller;
use think\Request;

class Index extends Controller
{
    /**
     * 商品
     */
    public function index()
    {

    }

    /**
     * 课程详情页
     * @param Request $request
     * @return \think\response\View
     */
    public function detail(Request $request)
    {
        $course_id = $request->get('id');       //获取get参数中的课程id

        //查询数据库中的课程信息
        $detail = CourseModel::find($course_id);
        if($detail)
        {
            //更新点击量
            CourseModel::where(['course_id'=>$course_id])->inc('click_count')->update();

            $data = [
                'detail'   => $detail
            ];
            return view('detail',$data);
        }else{
            $this->error('课程不存在','/');
        }

    }


}
