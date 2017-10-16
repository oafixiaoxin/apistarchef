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
	    
	    private $file_path = '/www/wwwroot/image/upload/';
	    
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
	    	$imageAry = $request->input('imageAry');
	    	
	    	for ( $i = 0 ; $i < count($imageAry) ; $i++ )
	    	{
	    		if ( preg_match('/^(data:\s*image\/(\w+);base64,)/', $imageAry[$i], $result) )
	    		{
	    			//匹配成功 
		    		if ( $result[2] == 'jpeg' )
		    		{
		    			$image_name = date('YmdHis').time().'.jpg';
		    		}
		    		else
		    		{
		    			$image_name = date('YmdHis').time().'.'.$result[2];
		    		}
		 
		    		$filepath = $this->file_path.'/'.$image_name;
		    		
		    		if ( file_put_contents($filepath, base64_decode(str_replace($result[1], '', $base64_str))) )
		    		{
		    			$id = DB::table('sc_image')->insertGetId([
		    				'filename' => $image_name
		    			]);
		    			$idStr .= $id.',';
		    		}
		    		else
		    		{
		    			return $this->output(Response::WRONG_PARAMS);
		    			die;
		    		}
	    		}
	    		else
	    		{
	    			return $this->output(Response::WRONG_IMG_PATTERN);
	    			die;
	    		}
	    	}
	    	return $this->output(Response::SUCCESS, $idStr);
	    	
	    	
	    }
	}
?>