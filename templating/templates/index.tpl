{extends file='base.tpl'}
	{block name="title"}{_HOME}{/block}
	{block name="maincontent"}
		{if isset($selectedLanguage) && $selectedLanguage->getDisplayName()!=""}
			<h1>{$selectedLanguage->getDisplayName()}</h1>
			<p class='addSnippet'><a href='index.php?mode=addsnippet&language={$selectedLanguage->getLanguageId()}'>{_ADD_SNIPPET}</a></p>
			<ul class='snipList'>
				{foreach $selectedLanguage->getSnippets() as $OneSnippet}
					<li><a href='index.php?mode=viewsnippet&snip={$OneSnippet->getId()}'>{$OneSnippet->getTitle()}</a></li>
				{/foreach}
			</ul>
		{/if}
		{if not languages::getAvailableLanguages()}
			<h1>{_ALL_LANGUAGES_DISABLED}</h1>
		{/if}
	{/block}
