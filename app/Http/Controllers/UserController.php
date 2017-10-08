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
	    	/*
	    	短信验证码登录
	    	号码存在时，直接登录
	    	号码不存在时，先进行注册，后登录
	    	*/
	    	$phone = $request->input('phone');
	    	if ( $this->checkUser($phone) )
	    	{
	    		return $this->output(Response::SUCCESS, $this->getUserInfo($phone));
	    	}
	    	else
	    	{
	    		$uid = uniqid();
	    		$regist = DB::select('INSERT INTO sc_user (`uid`,`account`,`password`,`nickname`,`sex`,`createtime`,`isactive`,`point`,`star`,`phone`) 
	    		VALUES (?,?,?,?,?,?,?,?,?,?)', [$uid, $phone, $phone, $phone, 0, time(), 1, 0, 0, $phone]);
	    		if ( $this->login($phone, null) == 1 )
	    		{
	    			return $this->output(Response::SUCCESS, $this->getUserInfo($phone));
	    		}
	    		else if ( $this->login($phone, null) == 2 )
	    		{
	    			return $this->output(Response::PASSWORD_INCORRECT);
	    		}
	    		else if ( $this->login($phone, null) == 3 )
	    		{
	    			return $this->output(Response::USER_NOT_FOUND);
	    		}
	    	}
	    }
	    
	    public function userLoginByAccount( Request $request )
	    {
	    	//帐号密码登录
	    	$phone = $request->input('phone');
	    	$password = $request->input('password');
	    	if ( $this->login($phone, $password) == 1 )
	    	{
	    		return $this->output(Response::SUCCESS, $this->getUserInfo($phone));
	    	}
	    	else if ( $this->login($phone, $password) == 2 )
	    	{
	    		return $this->output(Response::PASSWORD_INCORRECT);
	    	}
	    	else if ( $this->login($phone, $password) == 3 )
	    	{
	    		return $this->output(Response::USER_NOT_FOUND);
	    	}
	    }
	    
	    private function login( $phone, $password )
	    {
	    	if ( $this->checkUser($phone) )
	    	{
	    		if ( empty($password) )
	    		{
	    			return 1;
	    		}
	    		else
	    		{
	    			$checkPwd = DB::select('select * from sc_user where 1=1 and `phone`=? and `password`=?', [$phone, $password]);
	    			if ( !empty($checkPwd) )
	    			{
	    				return 1;
	    			}
	    			else
	    			{
	    				return 2;
	    			}
	    		}
	    	}
	    	else
	    	{
	    		return 3;
	    	}
	    }
	    
	    private function checkUser( $phone )
	    {
	    	$checkUser = DB::table('sc_user')->where('phone', $phone)->first();
	    	if ( !empty($checkUser) )
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}
	    }
	    
	    private function getUserInfo( $phone )
	    {
	    	$userInfo = DB::table('sc_user')->where('phone', $phone)->first();
	    	return $userInfo;
	    }
	}
?>