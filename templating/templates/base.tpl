<!doctype html>
<html>
<head>
  <title>{block name=title}KSnip{/block}</title>
	<meta charset='utf-8'> 
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />
	<script src="vendor/ace-src-min/ace.js" type="text/javascript" charset="utf-8"></script>
	<link href='style/style.css' rel='stylesheet' type='text/css' />
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
		{if isset($langHighlight)}
			<script type='text/javascript'>
			    var editor = ace.edit("editor");
			    editor.setTheme("ace/theme/tomorrow_night_bright");
			    editor.getSession().setMode("ace/mode/{$langHighlight}");
		    	editor.setDisplayIndentGuides(true);
		    	editor.setShowPrintMargin(false);
			    {if isset($highlightReadOnly)}
			    	editor.setReadOnly(true);
				{/if}	    
			</script>
		{/if}
		</div>
</body>
</html>
