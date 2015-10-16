{extends file='base.tpl'}
	{block name="title"}{_ADD_NEW_SNIPPET}{/block}
	{block name="maincontent"}
		{if isset($result)}
			{if $result=="OK"}
				<h1>{_ADDED}</h1>
				<p><a href='index.php?language={$selectedLanguage->getLanguageId()}'>{_BACK_TO} {$selectedLanguage->getDisplayName()} </a></p>
				{else}
				<h1>{$result}</h1>
			{/if}
			{else}
				{if isset($selectedLanguage) && $selectedLanguage->getDisplayName()!=""}
				<h1>{_ADD_NEW_SNIPPET} {$selectedLanguage->getDisplayName()}</h1>
				<form method="post" onsubmit="document.getElementsByName('snipContent')[0].value=editor.getValue()">
					<p>{_TITLE} :</p>
					<p><input required autofocus type="text" name="snipTitle" autocomplete="off" /></p>
					<p>{_CODE} :</p>
					<input type="hidden" name="snipContent"/>
					<div id="editor"></div>
					<p>Tags: </p>
					<p><input type='text' name='snipTags'/></p>
					<p><input type="submit" value="{_ADD}" /></p>			
				</form>
			{/if}
		{/if}
		
	{/block}
