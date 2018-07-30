<?php


namespace Linet\Http\Controllers;
use Illuminate\Http\Request;
use Linet\Bot;
use Linet\Template;
use Linet\Application;
use Auth;

class ApiController extends Controller
{
    public function getstyle($name)
    {
    	$css = Bot::getFileContents($name);
    	return response($css,200)->header('Content-Type','text/css');
    }

    public function getscript($name)
    {
    	return Bot::getFileContents($name);
    }

    public function api(Request $request, $endPoint)
    {
    	$user = Auth::user();

    	switch ($endPoint) {

    		case 'initializing':

    			$template = Template::where('username',$user->template)->first();
    			$components = $template->components;
    			$retVal = array();
    			$c = array();

    			$c[0] = $template->username;
    			$c[1] = Bot::getFileContents("os+".$template->username.".html");
    			$retVal[count($retVal)] = $c;

    			foreach($components as $component)
    			{
    				
    				$c[0] = $component;
    				$c[1] = Bot::getFileContents("os+".$template->username."-$component".".html");
    				$retVal[count($retVal)] = $c;
    			}


    			return $retVal;

    			break;
    		
    		default:
    			dd("LINET500"); //internal server error
    			break;
    	}
    }
}
