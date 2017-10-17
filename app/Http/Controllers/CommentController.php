<?php
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use App\Response;
	
	class CommentController extends Controller
	{
	    /**
	     * Create a new controller instance.
	     *
	     * @return void
	     */
	    
	    private $file_path = '/www/wwwroot/sc_image/';
	    
	    public function __construct()
	    {
	        //
	    }
	    
	    public function addComment(Request $request)
	    {
	    	$uid = $request->input('uid');
	    	$star = $request->input('star');
	    	$taste = $request->input('taste');
	    	$enviroment = $request->input('enviroment');
	    	$serve = $request->input('serve');
	    	$content = $request->input('content');
	    	$type = $request->input('type');
	    	$parentid = $request->input('parentid');
	    	$imageAry = $request->input('imageAry');
	    	$targetid = $request->input('targetid');
	    	$costaver = $request->input('costaver');
	    	$commentid = DB::table('sc_commit')->insertGetId([
	    		'uid' => $uid,
	    		'type' => $type,
	    		'time' => time(),
	    		'content' => $content,
	    		'parentid' => $parentid,
	    		'taste' => $taste,
	    		'environment' => $enviroment,
	    		'service' => $serve,
	    		'targetid' => $targetid
	    	]);
	    	if ( !empty($commentid) )
	    	{
	    		return $this->output(Response::SUCCESS);
	    	}
	    	else
	    	{
	    		return $this->output(Response::WRONG_OPERATION);
	    	}
	    }
	    
	}
?>