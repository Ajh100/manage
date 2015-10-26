<?php
/*
车源管理
 */
namespace Home\Controller;
use Think\Controller;
class CarController extends AdminController{
    
    public function index(){
        
        $map = array();
		$map['status'] = array('in', '1,2,3,4');
        if(IS_POST){
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }
            if(!empty($_POST['city_id'])){
                $map['city_id'] = $_POST['city_id'];
            }
            if(!empty($_POST['store_id'])){
                $map['store_id'] = $_POST['store_id'];
            }
            if(!empty($_POST['status'])){
                $map['status'] = $_POST['status'];
            }
        }
        
        $city = M('City')->order('area_id')->select();
        $store = M('Store')->order('city')->select();

        $model = M('Car');
        $count = $model->where($map)->count('id');
        $page  = new \Think\Page($count,12);
        $show  = $page->show();
        $list = $model->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        cookie('_currentUrl_',__SELF__);
        $this->assign(array(
            'city' => $city,
            'store'=> $store,
            'list' => $list,
            'page' => $show,
            'map' => $map,
            'count' => $count
        ));
        $this->display(); 
    }
    
    public function add(){
        $this->display();
    }
    
    public function edit($id){
        $car = M('Car')->find($id);
        
        $brand = M('CarBrand')->select();
        $saleman = M('Saleman')->where('uid ='.$car['uid'])->find();
        $color = M('CarColor')->select(); //车辆颜色
        $datatimeyear = range(2014,1991);
        $datatimedate = range(1, 12);
        $car_brand = M('CarBrand')->where('id='.$car['brand_id'])->find();
        $car_series = M('CarSeries')->find($car['series_id']);
        $car_class = M('CarClass')->find($car['class_id']);
        $car_year = M('CarYear')->field('title')->where('id = '.$car_class['style_id'])->find();
        $regtime = !empty($car['regtime'])?date('Y' , strtotime($car['regtime'])):'';
        $regtimedate_title = !empty($car['regtime'])?intval(date('m' , strtotime($car['regtime']))):'';
        $imglist = (array)json_decode($car['imglist']);

        $timelist = array(
            'regtime_title' => !empty($car['regtime'])?date('Y' , strtotime($car['regtime'])):'',
            'regtimedate_title' => !empty($car['regtime'])?intval(date('m' , strtotime($car['regtime']))):'',
            'inspeyear_title' => !empty($car['inspecyear'])?date('Y' , strtotime($car['inspecyear'])):'',
            'inspemonth_title' => !empty($car['inspecyear'])?intval(date('m' , strtotime($car['inspecyear']))):'',
            'inuyear_title' => !empty($car['inspecyear'])?date('Y' , strtotime($car['inspecyear'])):'',
            'inumonth_title' => !empty($car['isuranceyear'])?intval(date('m' , strtotime($car['isuranceyear']))):'',
        );

        //质检
        $qulist = M('CarQualityClass')->order('sort desc, id asc')->select();
        $quality_list = array();
        foreach ($qulist as $key => $value){
            $quality_list[$value['title']] =  M('CarQuality')->where('classid ='.$value['id'])->select();
        }
        $quality_value = M('CarQualityValue')->where('carid ='.$id)->find();

        //损伤图片
        $cardamage = M('CarDamage')->where('carid ='.$id)->find();
        $damage_arr = array(
            'damageid' => $cardamage['id'],
            'xy' => json_decode($cardamage['xy']),
            'imgurllist' => json_decode($cardamage['imgurl'])
        );

        $this->assign(array(
            'saleman' => $saleman,
            'color' => $color,
            'datatimeyear' => $datatimeyear,
            'datatimedate' => $datatimedate,
            'cardata' => $car,
            'car_brand' => $car_brand,
            'car_series' => $car_series,
            'car_class' => $car_class,
            'car_year' => $car_year,
            'timelist' => $timelist,
            'imglist' => $imglist,
            'quality_list' => $quality_list,
            'quality_value' => $quality_value,
            'quality_no_value' => (array)json_decode($quality_value['value']),
            'cardamage' => $damage_arr
        ));
        
        $this->display();
    }
    
    public function update(){
        if(empty($_POST['brand_title'])){
            $this->error('品牌不能为空');
        }
        if(empty($_POST['series_title'])){
            $this->error('车系不能为空');
        }
        if(empty($_POST['class_title'])){
            $this->error('车型不能为空');
        }
        if(empty($_POST['color_id'])){
            $this->error('颜色不能为空');
        }
        if(empty($_POST['filelist'])){
            $this->error('展示图片不能为空');
        }
        if(empty($_POST['price'])){
            $this->error('价格不能为空');
        }
        if(empty($_POST['owner'])){
            $this->error('车主不能为空');
        }
        if(empty($_POST['tel'])){
            $this->error('电话不能为空');
        }
        if(empty($_POST['description'])){
            $this->error('描述不能为空');
        }
        
        $carstyle = M('CarClass')->find(I('post.class_value'));
        
        $data = array();
        $data['title'] = I('post.brand_title').' '.I('post.series_title').' '.I('post.class_title');
        $data['brand_id'] = I('post.brand_value');
        $data['series_id'] = I('post.series_value');
        $data['class_id'] = I('post.class_value');
        $data['color_id'] = I('post.color_id');
        $data['year'] = substr(I('post.class_title'),0,4);
        $data['output'] = substr($carstyle['output'],0,-1);
        $data['esid_id'] = $carstyle['esid_id'];
        $data['gearbox'] = $carstyle['gearbox'];
        $data['level_id'] = $carstyle['level_id'];
        $filelist = I('post.filelist');
        $data['cover'] = $filelist[0];
        $data['imglist'] = json_encode($filelist);
        $data['price'] = I('post.price');
        $data['status'] = I('post.status');
        
        if($_POST['regtime_title']=='年份' || $_POST['regtimedate_title']=='日期'){
            $data['regtime'] = null;
        }else{
            $data['regtime'] = I('post.regtime_title').'-'.I('post.regtimedate_title').'-1';
        }
        
        if($_POST['inspeyear_title']=='年份' || $_POST['inspemonth_title']=='日期'){
            $data['inspecyear'] = null;
        }else{
            $data['inspecyear'] = I('post.inspeyear_title').'-'.I('post.inspemonth_title').'-1';
        }
        
        if($_POST['inuyear_title']=='年份' || $_POST['inumonth_title']=='日期'){
            $data['isuranceyear'] = null;
        }else{
            $data['isuranceyear'] = I('post.inuyear_title').'-'.I('post.inumonth_title').'-1';
        }
        
        $data['mileage'] = I('post.mileage');
        $data['owner'] = I('post.owner');
        $data['tel'] = I('post.tel');
        $data['description'] = I('post.description');
        $data['update_time'] = time();
        
         //质检信息
        if(!empty($_POST['quality'])){
            $quality_all = M('CarQuality')->field('id')->select();
            $quality_no = M('CarQuality')->where('id not in ('.implode(',', I('post.quality')).')')->getField('id',true);
            $arr_qty_key = array();
            $arr_qty_remark = array();
            foreach (I('post.qty_remark') as $key=>$value){
                if(!empty($value)){
                   $arr_qty_remark['k'.$quality_all[$key]['id'].''] = $value;
                   $arr_qty_key[] = $quality_all[$key]['id'];
                }
            }
            $quality_value = array(
                'carid' => I('post.id'),
                'qid'   => implode(',', $quality_no),
                'qvid'  => implode(',', $arr_qty_key),
                'value' => json_encode($arr_qty_remark)
            );
            $quality_res = M('CarQualityValue')->where('carid ='.I('post.id'))->find();

            if(is_array($quality_res)){
                $qua_res = M('CarQualityValue')->where('id ='.$quality_res['id'])->save($quality_value);
            }else{
                $qua_res = M('CarQualityValue')->add($quality_value);
            }            
        }

        //保存损伤图
        if(!empty($_POST['danmageid']) || !empty($_POST['damagefilelist'])){
            $damage_res = M('CarDamage')->where('carid ='.I('post.id'))->find();
            $damagefilelist = I('post.damagefilelist');
            $damagexy = I('post.damagexy');
            $daarr = array(
                'carid' => I('post.id'),
                'xy'    => json_encode($damagexy),
                'imgurl'=> json_encode($damagefilelist)
            );
            if(is_array($damage_res)){
                $daarr['id'] = I('post.danmageid');
                $dmage_resda = M('CarDamage')->data($daarr)->save();

            }else{
                $dmage_resda = M('CarDamage')->data($daarr)->add();
            }                
        }
        
        //保存车辆信息
        $result = D('Car')->where('id = '.I('post.id'))->data($data)->save();
        if($result !== false){            
            $this->success('编辑成功', cookie('_currentUrl_'));
        }else{
            $this->error('编辑失败');
        }       
        
    }
    
    public function under($id){
        if(!empty($id)){            
            $result = M('Car')->where('id ='.$id)->data(array('status'=>1))->save();
            if($result !== false){
                $this->success('下架成功', cookie('_currentUrl_'));
            }else{
                $this->error('下架失败');
            }
        }
    }
    
    public function refresh($id){
        if(!empty($id)){
            $result = M('Car')->where('id ='.$id)->data(array('update_time'=>time()))->save();
            if($result !== false){
                $this->success('刷新成功', cookie('_currentUrl_'));
            }else{
                $this->error('刷新失败');
            }
        }        
    }
}
