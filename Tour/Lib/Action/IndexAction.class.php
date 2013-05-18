<?php

class IndexAction extends Action {
    public function index(){
		// 缓存
		$cache = A('Cache');
		$cache->url = 'Index/index';
		if ($cache->isCached()) $cache->showPage();

		// 获取城市列表
		$cityList = D('City')->rList();
		$pointList = D('Point')->rList();
		$pointTypeList = D('PointType')->rList();
		$tmpConstList = D('Const')->rList('sell_count,satisfaction');
		$constList = array();
		foreach($tmpConstList as $item) {
			$constList[$item['name']] = $item['value'];
		}
		$lastOrder = D('Order')->rLast();
		$lastOrder['time'] = getTime() - $lastOrder['submit_time'];
		if ($lastOrder['time'] > 86400)
			$lastOrder['time'] = floor($lastOrder['time']/86400).'天';
		else
		if ($lastOrder['time'] > 3600)
			$lastOrder['time'] = floor($lastOrder['time']/3600).'小时';
		else
		if ($lastOrder['time'] > 60)
			$lastOrder['time'] = floor($lastOrder['time']/60).'分钟';
		else
			$lastOrder['time'] = floor($lastOrder['time']).'秒';
		$lastOrder['user'] = D('User')->r($lastOrder['user_id']);
		$lastOrder['user']['nickname'] = substr($lastOrder['user']['nickname'], 0, strlen($lastOrder['user']['nickname'])-2).'***';
		$lastOrder['user']['school'] = D('School')->rName($lastOrder['user']['school_id']);

		// 获取班级游信息
		$banji = array();
		$banji['pointTypeList'] = $pointTypeList;
		$banji['tagList'] = D('LineTag')->rList();
		$banji['provinceZB'] = D('Province')->rList(1);
		$banji['provinceGN'] = D('Province')->rList(2);
		$this->assign('banji', $banji);
		
		// 获取周边游信息
		$zhoubian = array();
		$zhoubian['pointTypeList'] = $pointTypeList;
		$zhoubian['pointList'] = D('Point')->rListByProvinceList(A('Line')->zhoubian, '`id`,`name_abb`,`subject_id`', '`count` DESC');
		foreach($zhoubian['pointList'] as $item) {
			foreach($zhoubian['pointTypeList'] as $key => $item2) {
				if (count($zhoubian['pointTypeList'][$key]['point']) >= 8) continue;
				if (strstr($item['subject_id'], ','.$item2['id'].',')) {
						if (A('Line')->searchNum('t=2&point='.$item['id']))
							$zhoubian['pointTypeList'][$key]['point'][] = $item;
						break;
				}
			}
		}
		$this->assign('zhoubian', $zhoubian);

		// 获取国内游信息
		$guonei = array();
		$guonei['pointTypeList'] = $pointTypeList;
		$guonei['provinceList'] = D('Province')->rList(2);
		$guonei['pointList'] = D('Point')->rListByProvinceList(A('Line')->guonei, '`id`,`name_abb`,`province_id`', '`count` DESC');
		foreach($guonei['pointList'] as $item) {
			foreach($guonei['provinceList'] as $key => $item2) {
				if (count($guonei['provinceList'][$key]['point']) >= 8) continue;
				if ($item['province_id'] == $item2['id']) {
						if (A('Line')->searchNum('t=2&point='.$item['id']))
							$guonei['provinceList'][$key]['point'][] = $item;
						break;
				}
			}
		}
		$this->assign('guonei', $guonei);
		
		// 获取出境游信息
		$chujing = array();
		$chujing['pointTypeList'] = $pointTypeList;
		$chujing['provinceList'] = D('Province')->rList(3);
		$chujing['pointList'] = D('Point')->rListByProvinceList('chujing', '`id`,`name_abb`,`province_id`', '`count` DESC');
		foreach($chujing['pointList'] as $item) {
			foreach($chujing['provinceList'] as $key => $item2) {
				if (count($chujing['provinceList'][$key]['point']) >= 8) continue;
				if ($item['province_id'] == $item2['id']) {
						if (A('Line')->searchNum('t=2&point='.$item['id']))
							$chujing['provinceList'][$key]['point'][] = $item;
						break;
				}
			}
		}
		$this->assign('chujing', $chujing);
		
		// 获取门票信息
		$menpiao = array();
		$menpiao['pointTypeList'] = $pointTypeList;
		$menpiao['provinceZB'] = D('Province')->rList(1);
		$menpiao['pointList'] = D('Point')->rListByProvinceList(A('Line')->zhoubian, '`id`,`name_abb`,`province_id`, `price`', '`count` DESC');
		foreach($menpiao['pointList'] as $item) {
			if ($item['price'] == 0) continue;
			foreach($menpiao['provinceZB'] as $key => $item2) {
				if (count($menpiao['provinceZB'][$key]['point']) >= 8) continue;
				if ($item['province_id'] == $item2['id']) {
						$menpiao['provinceZB'][$key]['point'][] = $item;
						break;
				}
			}
		}
		$this->assign('menpiao', $menpiao);

		$this->assign('cityList', $cityList);
		$this->assign('pointList', $pointList);
		$this->assign('pointTypeList', $pointTypeList);
		$this->assign('constList', $constList);
		$this->assign('lastOrder', $lastOrder);

		// 缓存
		if (!$cache->isCached()) {
			$cache->tvar = $this->tVar;
			$cache->cachePage();
		}
		$this->display();
    }

	// 添加所有城市
	public function addCity() {
		{	// 折叠专用
		$s = '安徽,安庆;安徽,蚌埠;安徽,亳州;安徽,巢湖;安徽,池州;安徽,滁州;安徽,阜阳;安徽,合肥;安徽,淮北;安徽,淮南;安徽,黄山;安徽,六安;安徽,马鞍山;安徽,宿州;安徽,铜陵;安徽,芜湖;安徽,宣城;北京,北京;福建,福州;福建,龙岩;福建,南平;福建,宁德;福建,莆田;福建,泉州;福建,三明;福建,厦门;福建,漳州;福建,其他;甘肃,白银;甘肃,定西;甘肃,甘南;甘肃,嘉峪关;甘肃,金昌;甘肃,酒泉;甘肃,兰州;甘肃,临夏;甘肃,陇南;甘肃,平凉;甘肃,庆阳;甘肃,天水;甘肃,武威;甘肃,张掖;甘肃,其他;广东,潮州;广东,东莞;广东,佛山;广东,广州;广东,河源;广东,惠州;广东,江门;广东,揭阳;广东,茂名;广东,梅州;广东,清远;广东,汕头;广东,汕尾;广东,韶关;广东,深圳;广东,阳江;广东,云浮;广东,湛江;广东,肇庆;广东,中山;广东,珠海;广东,其他;广西,百色;广西,北海;广西,崇左;广西,防城港;广西,贵港;广西,桂林;广西,河池;广西,贺州;广西,来宾;广西,柳州;广西,南宁;广西,钦州;广西,梧州;广西,玉林;广西,其他;贵州,安顺;贵州,毕节;贵州,贵阳;贵州,六盘水;贵州,黔东南;贵州,黔南;贵州,黔西南;贵州,铜仁;贵州,遵义;贵州,其他;海南,海口;海南,三亚;海南,其它;河北,保定;河北,沧州;河北,承德;河北,邯郸;河北,衡水;河北,廊坊;河北,秦皇岛;河北,石家庄;河北,唐山;河北,邢台;河北,张家口;河北,其他;河南,安阳;河南,鹤壁;河南,济源;河南,焦作;河南,开封;河南,洛阳;河南,漯河;河南,南阳;河南,平顶山;河南,濮阳;河南,三门峡;河南,商丘;河南,新乡;河南,信阳;河南,许昌;河南,郑州;河南,周口;河南,驻马店;河南,其他;黑龙江,大庆;黑龙江,大兴安岭;黑龙江,哈尔滨;黑龙江,鹤岗;黑龙江,黑河;黑龙江,鸡西;黑龙江,佳木斯;黑龙江,牡丹江;黑龙江,七台河;黑龙江,齐齐哈尔;黑龙江,双鸭山;黑龙江,绥化;黑龙江,伊春;黑龙江,其他;湖北,鄂州;湖北,恩施;湖北,黄冈;湖北,黄石;湖北,荆门;湖北,荆州;湖北,潜江;湖北,神农架林区;湖北,十堰;湖北,随州;湖北,天门;湖北,武汉;湖北,仙桃;湖北,咸宁;湖北,襄樊;湖北,孝感;湖北,宜昌;湖北,其他;湖南,长沙;湖南,株洲;湖南,湘潭;湖南,衡阳;湖南,邵阳;湖南,岳阳;湖南,常德;湖南,张家界;湖南,益阳;湖南,郴州;湖南,永州;湖南,怀化;湖南,娄底;湖南,湘西;湖南,其他;吉林,白城;吉林,白山;吉林,长春;吉林,吉林;吉林,辽源;吉林,四平;吉林,松源;吉林,通化;吉林,延边;吉林,其他;江苏,常州;江苏,淮安;江苏,连云港;江苏,南京;江苏,南通;江苏,苏州;江苏,宿迁;江苏,泰州;江苏,无锡;江苏,徐州;江苏,盐城;江苏,扬州;江苏,镇江;江苏,其他;江西,抚州;江西,赣州;江西,吉安;江西,景德镇;江西,九江;江西,南昌;江西,萍乡;江西,上饶;江西,新余;江西,宜春;江西,鹰潭;江西,其他;辽宁,鞍山;辽宁,本溪;辽宁,朝阳;辽宁,大连;辽宁,丹东;辽宁,抚顺;辽宁,阜新;辽宁,葫芦岛;辽宁,锦州;辽宁,辽阳;辽宁,盘锦;辽宁,沈阳;辽宁,铁岭;辽宁,营口;辽宁,其他;内蒙古,阿拉善盟;内蒙古,巴彦淖尔;内蒙古,包头;内蒙古,赤峰;内蒙古,鄂尔多斯;内蒙古,呼和浩特;内蒙古,呼伦贝尔;内蒙古,通辽;内蒙古,乌海;内蒙古,乌兰察布;内蒙古,锡林郭勒盟;内蒙古,兴安盟;内蒙古,其他;宁夏,固原;宁夏,凉山;宁夏,石嘴山;宁夏,吴忠;宁夏,银川;宁夏,中卫;宁夏,其他;青海,果洛;青海,海北;青海,海东;青海,海南;青海,海西;青海,黄南;青海,西宁;青海,玉树;青海,其他;山东,滨州;山东,德州;山东,东营;山东,菏泽;山东,济南;山东,济宁;山东,莱芜;山东,聊城;山东,临沂;山东,青岛;山东,日照;山东,泰安;山东,威海;山东,潍坊;山东,烟台;山东,枣庄;山东,淄博;山东,其他;山西,长治;山西,大同;山西,晋城;山西,晋中;山西,临汾;山西,吕梁;山西,朔州;山西,太原;山西,忻州;山西,阳泉;山西,运城;山西,其他;陕西,安康;陕西,宝鸡;陕西,汉中;陕西,商洛;陕西,铜川;陕西,渭南;陕西,西安;陕西,咸阳;陕西,延安;陕西,榆林;陕西,其他;上海,上海;四川,阿坝;四川,巴中;四川,成都;四川,达州;四川,德阳;四川,甘孜;四川,广安;四川,广元;四川,乐山;四川,泸州;四川,眉山;四川,绵阳;四川,内江;四川,南充;四川,攀枝花;四川,遂宁;四川,雅安;四川,宜宾;四川,资阳;四川,自贡;四川,其他;天津,天津;西藏,阿里;西藏,昌都;西藏,拉萨;西藏,林芝;西藏,那曲;西藏,日喀则;西藏,山南;西藏,其他;新疆,阿克苏;新疆,阿勒泰;新疆,巴州;新疆,博州;新疆,昌吉州;新疆,哈密;新疆,和田;新疆,喀什;新疆,克拉玛依;新疆,克州;新疆,塔城;新疆,吐鲁番;新疆,乌鲁木齐;新疆,伊犁州直;新疆,其他;云南,版纳;云南,保山;云南,楚雄;云南,大理;云南,德宏;云南,迪庆;云南,红河;云南,昆明;云南,丽江;云南,临沧;云南,怒江;云南,普洱;云南,曲靖;云南,文山;云南,玉溪;云南,昭通;云南,其他;浙江,杭州;浙江,湖州;浙江,嘉兴;浙江,金华;浙江,丽水;浙江,宁波;浙江,衢州;浙江,绍兴;浙江,台州;浙江,温州;浙江,舟山;浙江,其他;重庆,重庆;';
		}
		$cityList = split(';', $s);
		$lastProvince = '';
		foreach($cityList as $item) {
			$a = split(',', $item);
			$provinceName = $a[0];
			$cityName = $a[1];
			if ($lastProvince == $provinceName) continue;
			$lastProvince = $provinceName;
			$province = D('Province')->rByName($provinceName);
			if (empty($province)) {
				echo $provinceName.' '.$cityName.'<br>';
				$data = array();
				$data['name'] = $provinceName;
				D('Province')->c($data);
			}
			//dump($province);
			
		}
		//dump($cityList);
	}
}