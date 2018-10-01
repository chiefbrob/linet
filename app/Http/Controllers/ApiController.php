<?php


namespace Linet\Http\Controllers;
use Illuminate\Http\Request;
use Linet\Bot;
use Linet\Template;
use Linet\Application;
use Auth;
use Linet\Notification;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

            case 'user-data':

                $retVal = array(
                    'LINET000',
                    Auth::user()->apps,
                    $user->notifications,
                );
                return $retVal;
                break;
            case 'mtengenezi-myApps':
                return Application::where('owner',Auth::user()->id)->get();
                break;

            case 'mtengenezi-loadApp':

                $app = Application::where('username',$request->username)->first();

                $retVal = array();
                $retVal[0] = $app;
                $retVal[1] = Bot::getFileContents($app->username . '.html');
                $retVal[2] = Bot::getFileContents($app->username . '.js');
                $retVal[3] = Bot::getFileContents($app->username . '.css');

                return $retVal;

                break;

            case 'mtengenezi-commitApp':

                $app = Application::where('username',$request->username)->first();

                if(!$app || $app->owner !== Auth::user()->id)
                    return 'LINET500';


                Bot::putFileContents($app->username.'.js',$request->script);
                Bot::putFileContents($app->username.'.css',$request->style);
                Bot::putFileContents($app->username.'.html',$request->data);

                return 'LINET000';

                break;
    		
            case 'applications':
                $user = Auth::user();
                $retVal = array();

                $retVal['all'] = Application::all(); 
                $retVal['installed'] = $user->apps;
                return $retVal;               
                break;

            case 'install-application':
                $app = Application::where('username',$request->username)->first();
                if(Auth::user()->installApp($app))
                    return ['LINET000',$app];
                else
                    return 'LINET500';

            case 'uninstall-application':
                $app = Application::where('username',$request->username)->first();
                
                if(Auth::user()->uninstallApp($app))
                    return ['LINET000',$app];
                else
                    return 'LINET500';
                break;

    		default:
    			return "LINET500"; //internal server error
    			break;
    	}
    }
}
