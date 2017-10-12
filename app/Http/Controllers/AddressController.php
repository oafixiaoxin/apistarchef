<?php
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use App\Response;
	
	class AddressController extends Controller
	{
	    /**
	     * Create a new controller instance.
	     *
	     * @return void
	     */
	    public function __construct()
	    {
	        //
	    }
	    
	    public function getAddressList( $uid )
	    {
	    	$result = DB::select('select * from sc_address where 1=1 and `uid`=?', [$uid]);
	    	if ( count($result) != 0 )
	    	{
	    		return $this->output(Response::SUCCESS, $result);
	    	}
	    	else
	    	{
	    		return $this->output(Response::NO_MORE_INFO);
	    	}
	    }
	    
	    public function addAddress( Request $request )
	    {
	    	$uid = $request->input('uid');
	    	$name = $request->input('name');
	    	$contact = $request->input('contact');
	    	$address = $request->input('address');
	    	$mailcode = $request->input('mailcode');
	    	
	    	$lt5 = DB::select('select * from sc_address where 1=1 and `uid`=?', [$uid]);
	    	if ( count($lt5) >= 5 )
	    	{
	    		return $this->output(Response::ADDRESS_LT_5);
	    	}
	    	
	    	$result = DB::table('sc_address')->insertGetId(
	    		[
	    			'uid' => $uid,
	    			'name' => $name,
	    			'contact' => $contact,
	    			'address' => $address,
	    			'mailcode' => $mailcode
	    		]
	    	);
	    	
	    	if ( !empty($result) )
	    	{
	    		return $this->output(Response::SUCCESS);
	    	}
	    	else
	    	{
	    		return $this->output(Response::WRONG_OPERATION);
	    	}
	    }
	    
	    public function setAddressUsed( Request $request )
	    {
	    	$uid = $request->input('uid');
	    	$addressid = $request->input('addressid');
	    	
	    	$usingAddressId = DB::select('SELECT id FROM sc_address WHERE 1=1 AND uid=? AND isused=1', [$uid]);
	    	$updateToNormal = DB::select('update sc_address set isused=0 where 1=1 and uid=? and `id`=?', [$uid, $usingAddressId[0]->id]);
	    	$updateToUsed = DB::select('update sc_address set isused=1 where 1=1 and uid=? and `id`=?', [$uid, $addressid]);
	    	
	    	return $this->output(Response::SUCCESS, $updateToUsed);
	    	
	    }
	    
	    public function deleteAddress( Request $request )
	    {
			$uid = $request->input('uid');
			$addressStr = $request->input('addressStr');
			$addressid = explode(',', $addressStr);
			for ( $i = 0 ; $i < count($addressid) ; $i++ )
			{
				$deleteOp = DB::delete('DELETE FROM sc_address WHERE 1=1 AND uid=? AND id=?', [$uid, $addressid[$i]]);
			}
			return $this->output(Respon::SUCCESS);
	    }
	    
	    public function getProvince()
	    {
	    	$province = DB::select('SELECT id,title FROM sc_pro_city_area WHERE 1=1 AND `type`=1 AND `parentid`=0');
	    	return $this->output(Response::SUCCESS, $province);
	    }
	    
	    public function getCity( $provinceId )
	    {
	    	$city = DB::select('SELECT id,title FROM sc_pro_city_area WHERE 1=1 AND `parentid`=? AND `type`=2', [$provinceId]);
	    	return $this->output(Response::SUCCESS, $city);
	    }
	    
	    public function getArea( $cityId )
	    {
	    	$area = DB::select('SELECT id,title FROM sc_pro_city_area WHERE 1=1 AND `parentid`=? AND `type`=3', [$cityId]);
	    	return $this->output(Response::SUCCESS, $area);
	    }
	    
	    public function setProCityArea( Request $request )
	    {
	    	$proCityArea = json_decode($request->input('proCityArea'));
	    	for ( $i = 1 ; $i < count($proCityArea) - 1 ; $i++ )
	    	{
	    		$id1 = DB::table('sc_pro_city_area')->insertGetId(
	    			['parentid' => 0, 'title' => $proCityArea[$i]->name, 'type' => 1]
	    		);
	    		$isThree = false;
	    		if ( $proCityArea[$i]->type == 0 )
	    		{
	    			$id2 = DB::table('sc_pro_city_area')->insertGetId(
			    		['parentid' => $id1, 'title' => $proCityArea[$i]->name, 'type' => 2]
			    	);
			    	$isThree = true;
	    		}
	    		for ( $j = 0 ; $j < count($proCityArea[$i]->sub) ; $j++ )
	    		{
	    			if ( $proCityArea[$i]->sub[$j]->name != "请选择" && $proCityArea[$i]->sub[$j]->name != "其他" )
		    		{
		    			$t = $isThree?3:2;
		    			$id2 = DB::table('sc_pro_city_area')->insertGetId(
				    		['parentid' => $id1, 'title' => $proCityArea[$i]->sub[$j]->name, 'type' => $t]
				    	);
				    	if ( isset($proCityArea[$i]->sub[$j]->sub) )
				    	{
				    		for ( $k = 0 ; $k < count($proCityArea[$i]->sub[$j]->sub) ; $k++ )
					    	{
					    		if ( $proCityArea[$i]->sub[$j]->sub[$k]->name != "请选择" && $proCityArea[$i]->sub[$j]->sub[$k]->name != "其他" )
					    		{
					    			$id3 = DB::table('sc_pro_city_area')->insertGetId(
						    			['parentid' => $id2, 'title' => $proCityArea[$i]->sub[$j]->sub[$k]->name, 'type' => 3]
						    		);
					    		}
					    	}
				    	}
		    		}
	    		}
	   		}    	
	    }
	    
	}
?>