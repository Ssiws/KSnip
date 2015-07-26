<!doctype html>
<html>
<head>
  <title>{block name=title}KSnip{/block}</title>
  <link rel="stylesheet" type="text/css" href="static/style.css">
	<meta charset='utf-8'> 
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />
	<script type='text/javascript' src='sh3/shCore.js'></script>
	<script type='text/javascript' src='sh3/shAutoloader.js'></script>
	<link href='style/style.css' rel='stylesheet' type='text/css' />
	<link href='sh3/shCore.css' rel='stylesheet' type='text/css' />
	<link href='sh3/shThemeMidnight.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<aside id="languagesSelector">
		<ul>
			{foreach languages::getAvailableLanguages() as $OneLanguage}
				<li>
					<a href='index.php?language={$OneLanguage->getLanguageID()}'>
						{$OneLanguage->getDisplayName()}
					</a>
				</li>
			{/foreach}
			<li id='settingsButton'>
				<a href='settings.php'><img width=40 src='img/settings.png' alt="settings"/></a>
			</li>
		</ul>
	</aside>
	<div id="wrapper">
		<div id="main">
			{block name=maincontent}{/block}
		</div>
		
		{* FOOTER *}
		<script type='text/javascript'>
				function path()
				  {
					var args = arguments,
						result = [];
	
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
							if(e.shiftKey){
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
		</div>
</body>
</html>
