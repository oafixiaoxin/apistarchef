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
//	    	$uid = $request->input('uid');
//	    	$star = $request->input('star');
//	    	$taste = $request->input('taste');
//	    	$enviroment = $request->input('enviroment');
//	    	$serve = $request->input('serve');
//	    	$content = $request->input('content');
//	    	$type = $request->input('type');
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
		    		
//		    		if ( !file_exists($this->file_path.date('Ymd',time()).'/') )
//		    		{
//		    			return $this->output(Response::SUCCESS, $this->file_path.date('Ymd',time()).'/');
//	    				mkdir($this->file_path.date('Ymd',time()).'/', 0700);
//		    		}
//		    		else
//		    		{
//		    			return $this->output(Response::SUCCESS, "yanshuxin");
//		    		}
		 
		    		$filepath = $this->file_path.$image_name;
//		    		return $this->output(Response::SUCCESS, $filepath);
		    		
		    		if ( file_put_contents($filepath, base64_decode(str_replace($result[1], '', $imageAry[$i]))) )
		    		{
		    			$id = DB::table('sc_image')->insertGetId([
		    				'filepath' => $image_name
		    			]);
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
	    }
	    
	}
?>