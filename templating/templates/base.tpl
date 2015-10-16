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
		
		{* Fonction qui permet de filtrer en live la vue *}
		<script type="text/javascript">
			var input = document.getElementById('input');
			input.onkeyup = function() {
				var filter = input.value.toUpperCase();
				var lis = document.getElementsByClassName('snippet');
				
				for(var i=0; i<lis.length; i++) {
					var name = lis.item(i).textContent.trim();
					if (name.toUpperCase().indexOf(filter) != -1){
						lis[i].style.display = 'list-item';
					}
					else{
						lis[i].style.display = 'none';
					}
				}
			}
		</script>
		</div>
</body>
</html>
