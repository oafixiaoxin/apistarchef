<?php
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use App\Response;
	
	class CollectionController extends Controller
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
	    
	    public function addCollection( Request $request )
	    {
	    	$uid = $request->input('uid');
	    	$targetid = $request->input('targetid');
	    	$type = $request->input('type');
	    	$time = time();
	    	
	    	$collectionid = DB::table('sc_collection')->insertGetId([
	    		'uid' => $uid,
	    		'targetid' => $targetid,
	    		'type' => $type,
	    		'time' => $time
	    	]);
	    	
	    	if ( $collectionid > 0 )
	    	{
	    		return $this->output(Response::SUCCESS);
	    	}
	    	else
	    	{
	    		return $this->output(Response::COLLECTION_FAILED);
	    	}
	    }
	    
	    public function cancelCollection( Request $request )
	    {
	    	$uid = $request->input('uid');
	    	$targetid = $request->input('targetid');
	    	$type = $request->input('type');
	    	
	    	$rows = DB::delete('delete from sc_collection where 1=1 and `uid`=? and `targetid`=? and `type`=?', [$uid, $targetid, 'shop']);
	    	if ( $rows == 1 )
	    	{
	    		return $this->output(Response::SUCCESS);
	    	}
	    	else
	    	{
	    		return $this->output(Response::WRONG_OPERATION);
	    	}
	    }
	    
	    public function getCollection( $uid, $type )
	    {
	    	$selectStr = 'SELECT ta.*,tb.* FROM sc_collection ta ';
	    	if ( $type == 'all' )
	    	{
	    		
	    	}
	    	else
	    	{
	    		if ( $type == 'shop' )
	    		{
	    			$leftjoinStr = 'LEFT JOIN sc_shop tb ON ta.`targetid`=tb.shopid ';
		    	}
		    	$whereStr = 'WHERE 1=1 AND ta.uid=? AND ta.`type`=? ';
		    	$orderStr = 'ORDER BY ta.time DESC';
		    	
		    	$result = DB::select($selectStr.$leftjoinStr.$whereStr.$orderStr, [$uid, $type]);
		    	if ( count($result) > 0 )
		    	{
		    		return $this->output(Response::SUCCESS, $result);
		    	}
		    	else
		    	{
		    		return $this->output(Response::NO_MORE_INFO);
		    	}
	    	}
	    	
	    }
	    
	}
?>