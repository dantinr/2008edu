<?php
namespace app\course\controller;
use app\model\CoursefavModel;
use app\model\CourseModel;
use app\model\MycourseModel;
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
        $uid = session('uid');

        //查询数据库中的课程信息
        $detail = CourseModel::find($course_id);
        if($detail)
        {
            //更新点击量
            CourseModel::where(['course_id'=>$course_id])->inc('click_count')->update();

            //检查学习状态 my_course表
            $record = MycourseModel::where(['uid'=>$uid,'course_id'=>$course_id])->find();
            if($record)
            {
                $learn_status = 1;
            }else{
                $learn_status = 0;
            }

            //检查是否已收藏
            $fav = CoursefavModel::where(['uid'=>$uid,'course_id'=>$course_id])->find();
            if($fav)
            {
                $is_fav = 1;
            }else{
                $is_fav = 0;
            }


            $data = [
                'detail'            => $detail,
                'learn_status'      => $learn_status,       //学习状态
                'is_fav'            => $is_fav,             //是否收藏
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
        $state = $request->get('state');        //收藏状态  1取消收藏 0 收藏


        if($state){     //收藏

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

            CoursefavModel::create($data);
        }else{      //取消收藏
            CoursefavModel::where(['uid'=>$uid,'course_id'=>$course_id])->delete();
        }


        $response = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        return json($response);             //使用 thinkphp中的 json方法格式化
    }


    /**
     * 加入学习
     */
    public function addlearn(Request $request)
    {
        $course_id = $request->get('id');       //课程id
        $detail = CourseModel::find($course_id);       //获取课程信息
        $uid = session('uid');


        //检查是否有学习记录，没有则入库
        $record = MycourseModel::where(['uid'=>$uid,'course_id'=>$course_id])->find();
        if($record){
            // TODO
        }else{
            //记录我的课程
            $data = [
                'uid'       => session('uid'),
                'course_id' => $course_id,
                'add_time'  => time()
            ];

            MycourseModel::create($data);
        }

        $data = [
            'detail'    => $detail
        ];
        return view('add-learn',$data);
    }

}
