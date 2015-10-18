{extends file='base.tpl'}
	{block name="title"}{_SNIPPET}{/block}
	{block name="maincontent"}
		<h1>{_SNIPPET}</h1>
		{if isset($snippet)}
		
			{assign var="langHighlight" value="{$snippet->getLanguage()->getShortName()}"}
			{assign var="highlightReadOnly" value="true"}
			<p>
				<h2>{$snippet->getTitle()}</h2>
				<a href='index.php?mode=deletesnippet&snipId={$snippet->getId()}'><img src='img/del.png' alt="delete"/> {_DELETE}</a>
				<a href='index.php?mode=editsnippet&snip={$snippet->getId()}'><img src='img/edit.png' alt="edit"/> {_EDIT}</a>
			</p>
			<div id="editor">{$snippet->getContent()}</div>
			
		{else}
			{_ERR_INVALID_SNIPPET}
		{/if}
		
	{/block}