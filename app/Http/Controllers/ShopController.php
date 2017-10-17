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
	    
	    public function getShopInfo ( $shopid )
	    {
	    	$shopInfo = DB::table('sc_shop')->where('shopid', $shopid)->first();
			$voucherInfo = DB::select('SELECT ta.*,COUNT(tb.id) AS sold FROM sc_voucher ta 
LEFT JOIN sc_voucher_usage tb ON ta.id=tb.voucherid
WHERE 1=1 AND ta.shopid=?
GROUP BY ta.id', [$shopid]);
			$commentInfo = DB::select('SELECT ta.*,tb.nickname,tb.`avatar`,tb.star FROM sc_comment ta
LEFT JOIN sc_user tb ON ta.uid=tb.uid
WHERE 1=1 AND ta.`type`="shop" AND ta.`targetid`="S0001"
ORDER BY ta.time DESC
LIMIT 0,2', [$shopid]);
	    	
	    	$retAry = array();
	    	$retAry['shopinfo'] = $shopInfo;
	    	$retAry['voucherinfo'] = $voucherInfo;
	    	$retAry['commentinfo'] = $commentInfo;
	    	
	    	return $this->output(Response::SUCCESS, $retAry);
	    }
	}
?>