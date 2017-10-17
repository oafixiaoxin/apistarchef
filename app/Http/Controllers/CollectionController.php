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
	    
	}
?>