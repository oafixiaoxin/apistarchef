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
	    	$imageAry = $request->input('imageAry');
	    	return $this->output(Response::SUCCESS, $imageAry);
	    }
	}
?>