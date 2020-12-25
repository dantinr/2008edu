<?php
namespace app\course\controller;
use app\model\CoursefavModel;
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

    /**
     * 收藏课程
     */
    public function favcourse(Request $request)
    {
        $uid = session('uid');                  //获取用户id
        $course_id = $request->post('id');      //获取课程id

        //判断是否已收藏过
        $record = CoursefavModel::where(['uid'=>$uid,'course_id'=>$course_id])->find();
        if($record){
            $response = [
                'errno' => 500002,
                'msg'   => '已收藏过，请勿重复收藏'
            ];
            return json($response);
        }

        $data = [
            'course_id' => $course_id,
            'uid'       => $uid,
            'add_time'  => time()               //收藏时间
        ];

        $res = CoursefavModel::create($data);

        if($res->id){       //收藏成功
            $response = [
                'errno' => 0,
                'msg'   => 'ok'
            ];
        }else{
            $response = [
                'errno' => 500001,
                'msg'   => '收藏失败'
            ];
        }

        return json($response);             //使用 thinkphp中的 json方法格式化
    }



}
