{extends file='base.tpl'}
{block name="title"}{_EDIT_SNIPPET}{/block}
{block name="maincontent"}
	{if isset($snippetToEdit)}
		{if isset($resultat)}
			{if $resultat=="OK"}
				<h1>{_EDIT_DONE}</h1>
				<a href="index.php?mode=viewsnippet&snip={$snippetToEdit->getId()}">{_SHOW_THIS_SNIPPET}</a>
				{else}
				<h1>{_ERROR}</h1>
				<p>{$resultat}</p>
			{/if}
			{else}
				<h1>{_EDIT_SNIPPET}: {$snippetToEdit->getTitle()}</h1>
				
				<form method="post" onsubmit="document.getElementsByName('snipContent')[0].value=editor.getValue()">
					<p>{_TITLE}</p>
					<p><input required type='text' name='snipTitle' value='{$snippetToEdit->getTitle()}'/></p>
					<p>{_CODE}: </p>
					<input type="hidden" name="snipContent"/>
					<div id="editor">{$snippetToEdit->getContent()}</div>
					<p>Tags (Séparés par des points-virgules) : </p>
					<p><input type='text' name='snipTags' value='{$snippetToEdit->getTags()}'/></p>
					<p><input type="submit" value="{_EDIT}"/></p>
				</form>
		{/if}
	{/if}
{/block}