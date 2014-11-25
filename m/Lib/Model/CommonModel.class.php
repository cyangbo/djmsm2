<?php
class CommonModel extends Model {
	public function getPosition($id){

                $type = D('Category')->where('status=1')->find($id);
                if($type['pid']==0){
                        $position = array('id'=>$id,'catname'=>$type['catname']) ;
                }else{
                        $position =$this->getPosition($type['pid']);
                }
                return $position;
	}
	public function getCategoryMap($id){
		$type = D('Category')->where('status=1')->find($id);
		if($type['pid']==0){
			$types = D('Category')->where('status=1 AND pid='.$type['id'])->select();
			if(is_array($types)){
                            foreach($types as $val) $ary[]=$val['id'];
			}
			$map['catid']	= array('in',$ary);
		}else{
			$map['catid'] = array('eq',$id);
		}
		return $map;		
	}
}