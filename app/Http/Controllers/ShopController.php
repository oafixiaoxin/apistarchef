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
	    	$voucherInfo = DB::table('sc_voucher')->where('shopid', $shopid)->get();
	    	
	    	$retAry = array();
	    	$retAry['shopinfo'] = $shopInfo;
	    	$retAry['voucherinfo'] = $voucherInfo;
	    	
	    	return $this->output(Response::SUCCESS, $retAry);
	    }
	}
?>