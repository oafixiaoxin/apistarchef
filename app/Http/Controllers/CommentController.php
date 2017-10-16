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
		    		
		    		if ( !file_exists($this->file_path.date('Ymd',time()).'/') )
		    		{
	    				mkdir($this->file_path.date('Ymd',time()).'/', 0700);
		    		}
		 
		    		$filepath = $this->file_path.date('Ymd',time()).'/'.$image_name;
		    		
		    		if ( file_put_contents($filepath, base64_decode(str_replace($result[1], '', $imageAry[$i]))) )
		    		{
		    			$id = DB::table('sc_image')->insertGetId([
		    				'filepath' => date('Ymd',time()).$image_name
		    			]);
//		    			$idStr .= $id.',';
		    			return $this->output(Response::SUCCESS, $id);
		    		}
		    		else
		    		{
		    			
		    		}
	    		}
	    		else
	    		{
	    			
	    		}
	    	}
//	    	return $this->output(Response::SUCCESS, $idStr);
	    	
	    	
	    }
	}
?>