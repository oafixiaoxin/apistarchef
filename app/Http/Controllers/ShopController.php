<?php
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use App\Response;
	
	class ShopController extends Controller
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
	    
	    public function getShopList ()
	    {
	    	$result = DB::select('SELECT * FROM sc_shop WHERE 1=1 AND `status`=1');
	    	if ( count($result) != 0 )
	    	{
	    		return $this->output(Response::SUCCESS, $result);
	    	}
	    	else
	    	{
	    		return $this->output(Response::NO_MORE_INFO);
	    	}
	    }
	    
	    public function getShopInfo ( $shopid, $uid )
	    {
	    	$shopInfo = DB::table('sc_shop')->where('shopid', $shopid)->first();
			$voucherInfo = DB::select('SELECT ta.*,COUNT(tb.id) AS sold FROM sc_voucher ta 
LEFT JOIN sc_voucher_usage tb ON ta.id=tb.voucherid
WHERE 1=1 AND ta.shopid=?
GROUP BY ta.id', [$shopid]);
			$commentInfo = DB::select('SELECT ta.*,tb.nickname,IFNULL(tb.`avatar`,"") AS avatar,tb.star FROM sc_comment ta
LEFT JOIN sc_user tb ON ta.uid=tb.uid
WHERE 1=1 AND ta.`type`="shop" AND ta.`targetid`=?
ORDER BY ta.time DESC
LIMIT 0,2', [$shopid]);
			if ( $uid != '1' )
			{
				$isCollect = DB::table('sc_collection')->where([
					['uid', $uid],
					['targetid', $shopid],
					['type', 'shop']
				])->first();
			}
			
	    	$retAry = array();
	    	$retAry['shopinfo'] = $shopInfo;
	    	if ( isset($isCollect->id) )
	    	{
	    		$retAry['isCollect'] = $isCollect->id;
	    	}
	    	else
	    	{
	    		$retAry['isCollect'] = '';
	    	}
	    	$retAry['voucherinfo'] = $voucherInfo;
	    	$retAry['commentinfo'] = $commentInfo;
	    	
	    	return $this->output(Response::SUCCESS, $retAry);
	    }
	}
?>