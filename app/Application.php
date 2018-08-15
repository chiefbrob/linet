<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{

	protected $fillable = [
        'name','icon', 'username' ,'owner', 'description'
    ];

    public static function mtengeneziRegister($username){

    	$app = Application::where('username',$username)->first();

    	if(!$app)
    		return false;

    	$path = "apps/mtengenezi/files/$username";
    	Storage::makeDirectory($path);

    	$script = "
/* @$username */ 

console.log('@$username script running');

";
    	$style = "
/* $username style */ 

#$username { 

}
";
    	$data = "
<!-- HTML content -->

<div id='".$username."' class='application hidden' username='".$username."'>

    	<div class='application-header'>
        	<img src='storage/images/icons/icon-app.png' class='left-side' />
        	<b>".$app->name."</b>
            <button class='button red-button right-side application-closeButton' username='".$username."'>X</button>
            <img src='storage/images/icons/icon-more.png' class='right-side' />
            
        </div>
    <div class='application-body'>
        <div class='application-view' name='".$username."-welcome'>
		
		<!-- organize your data in views -->            
            
        </div>
    </div>
</div>
";

    	Storage::put($path."/$username.js",$script);
    	Storage::put($path."/$username.css",$style);
    	Storage::put($path."/$username.html",$data);

    	return true;
    }

    

}
