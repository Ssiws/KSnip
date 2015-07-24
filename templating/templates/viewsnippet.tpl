{extends file='base.tpl'}
	{block name="title"}{_SNIPPET}{/block}
	{block name="maincontent"}
		<h1>{_SNIPPET}</h1>
		{if isset($snippet)}
				<p>
				<h2>{$snippet->getTitle()} <a href='index.php?mode=deletesnippet&snipId={$snippet->getId()}'>{_DELETE}</a> <a href='index.php?mode=editsnippet&snip={$snippet->getId()}'>{_EDIT}</a></h2>
				
					<pre class='brush: {$language}; gutter: false; toolbar: false;'>
{$snippet->getContent()}
					</pre>
				</p>
			
		{else}
			{_ERR_INVALID_SNIPPET}
		{/if}
		
	{/block}
