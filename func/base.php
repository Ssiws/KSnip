<?php
require_once("locale/fr.php");
require_once("class/class.db.php");
function head($pageTitle){
	global $startTime;
	$startTime = microtime(true);
	
	echo "
	<!DOCTYPE html>
	<html>
			<head>
				<meta charset='utf-8'> 
				<meta http-equiv='X-UA-Compatible' content='IE=edge' />
				<title>$pageTitle</title>
				<style type='text/css'>
					@import url('style/style.css');
				</style>
				<script type='text/javascript' src='sh3/shCore.js'></script>
				<script type='text/javascript' src='sh3/shAutoloader.js'></script>
				<link href='sh3/shCore.css' rel='stylesheet' type='text/css' />
				<link href='sh3/shThemeMidnight.css' rel='stylesheet' type='text/css' />
			</head>
	";
	require_once( "class/class.db.php");
	require_once( "class/class.languages.php");
}

function foot(){
	global $startTime;
	$endTime = microtime(true);
	$genTime = ($endTime - $startTime);
	printf("
			<script type='text/javascript'>
			function path()
			  {
				var args = arguments,
					result = []
					;

				for(var i = 0; i < args.length; i++)
					result.push(args[i].replace('@', 'sh3/'));

				return result
			  };

			  SyntaxHighlighter.autoloader.apply(null, path(
				'ada		            @shBrushAda.js',
				'applescript            @shBrushAppleScript.js',
				'actionscript3 as3      @shBrushAS3.js',
				'bash shell             @shBrushBash.js',
				'bat batch	            @shBrushBat.js',
				'coldfusion cf          @shBrushColdFusion.js',
				'cpp c                  @shBrushCpp.js',
				'c# c-sharp csharp      @shBrushCSharp.js',
				'css                    @shBrushCss.js',
				'delphi pascal          @shBrushDelphi.js',
				'erl erlang             @shBrushErlang.js',
				'fsharp		            @shBrushFSharp.js',
				'groovy                 @shBrushGroovy.js',
				'java                   @shBrushJava.js',
				'jfx javafx             @shBrushJavaFX.js',
				'js jscript javascript  @shBrushJScript.js',
				'latex					@shBrushLatex.js',
				'perl pl                @shBrushPerl.js',
				'php                    @shBrushPhp.js',
				'powershell             @shBrushPowerShell.js',
				'text plain             @shBrushPlain.js',
				'py python              @shBrushPython.js',
				'ruby rails ror rb      @shBrushRuby.js',
				'sass scss              @shBrushSass.js',
				'scala                  @shBrushScala.js',
				'sql                    @shBrushSql.js',
				'vb vbnet               @shBrushVb.js',
				'xml xhtml xslt html    @shBrushXml.js'
			  ));
			  SyntaxHighlighter.all();
			  //Code to handle the 'tab' key when adding/editing snippet
			  var textarea= document.querySelector('textarea');
				textarea.onkeydown = function(e){
					if(e.keyCode==9 || e.which==9){ //Tab
						e.preventDefault();
						var s = this.selectionStart;
							if(window.event.shiftKey){
								//if shift is pressed -> remove one tab
								this.value = this.value.replace('\t','');
								this.selectionEnd = s-1 //put cursor before start position
							}else{
							this.value = this.value.substring(0,this.selectionStart) + '\t' + this.value.substring(this.selectionEnd);
							this.selectionEnd = s+1; //put cursor after start position
							}
						}
					}
			</script>
			<div id='footInfo'>KSnip v0.1 - %.2f ms</div>
		</body>
	</html>
	",$genTime*1000);
}
function getLanguageSelector(){
	$languages=new languages();
	$allLanguages=$languages->getAvailableLanguages();
	echo "<div id=\"languagesSelector\">";
		echo "<ul>";
			foreach ($allLanguages as $lang){
				echo "<li>\n";
					echo "<a href='index.php?language=".$lang->getLanguageId()."'>".$lang->getDisplayName()."</a>\n";
				echo "</li>\n";
			}
			echo "<li id='settingsButton'><a href='settings.php'><img width=40px src='img/settings.png'/></a></li>";
			echo"</ul>
		</div>";

}
function setup(){
	mkdir("data");
	$db=new db();
	$db->setup();
}
?>