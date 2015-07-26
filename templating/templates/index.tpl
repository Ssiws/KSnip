{extends file='base.tpl'}
	{block name="title"}{_HOME}{/block}
	{block name="maincontent"}
		{if isset($selectedLanguage) && $selectedLanguage->getDisplayName()!=""}
			{assign "langId" $selectedLanguage->getLanguageId()}
			{assign "langName" $selectedLanguage->getDisplayName()}
			<h1>{$langName}</h1>
			{if $wantedTag!=""}<h2>{_SNIPPET_WITH_THE_TAG} "{$wantedTag|escape}" {_IN} {$langName} <a href='?language={$langId}'>({_SHOW_ALL} {$langName})</a></h2>{/if}
			<p class='addSnippet'><a href='index.php?mode=addsnippet&amp;language={$langId}'>{_ADD_SNIPPET}</a></p>
			<ul class='snipList'>
				{foreach $selectedLanguage->getSnippets($wantedTag) as $OneSnippet}
					<li>
						<a href='index.php?mode=viewsnippet&amp;snip={$OneSnippet->getId()}'>{$OneSnippet->getTitle()}</a>
						{assign var=Tags value=";"|explode:$OneSnippet->getTags()}
						{if !empty($Tags[0])}
							<div class="tags">
								<img src="img/tag.png"/>
								{foreach $Tags as $OneTag}
									<a href="?language={$langId}&amp;tag={$OneTag|escape:'url'}">{$OneTag|escape}</a>
								{/foreach}
							</div>
						{/if}
					</li>
				{/foreach}
			</ul>
		{/if}
		{if not languages::getAvailableLanguages()}
			<h1>{_ALL_LANGUAGES_DISABLED}</h1>
		{/if}
	{/block}
