<?php
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Http\Request;
	use App\Response;
	
	class UserController extends Controller
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
	    
	    public function userLoginByCode( Request $request )
	    {
	    	//短信验证码登录
	    	//号码存在时，直接登录
	    	//号码不存在时，先进行注册，后登录
	    	$phone = $request->input('phone');
	    	if ( empty($phone) )
	    	{
	    		return $this->output(Response::WRONG_PARAMS);
	    	}
	    	else
	    	{
	    		return $this->output(Response::SUCCESS);
	    	}
	    }
	    
	    public function userLoginByAccount( Request $requset )
	    {
	    	//帐号密码登录
	    }
	}
?>