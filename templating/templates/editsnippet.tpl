{extends file='base.tpl'}
{block name="title"}{_EDIT_SNIPPET}{/block}
{block name="maincontent"}
	{if isset($snippetToEdit)}
		{if isset($resultat)}
			{if $resultat=="OK"}
				<h1>Modification effectuée!</h1>
				<a href="index.php?mode=viewsnippet&snip={$snippetToEdit->getId()}">Afficher ce snippet</a>
				{else}
				<h1>Erreur</h1>
				<p>{$resultat}</p>
			{/if}
			{else}
				<h1>{_EDIT_SNIPPET}: {$snippetToEdit->getTitle()}</h1>
				<form method="post">
				<p>{_TITLE}</p>
				<p><input required type='text' name='snipTitle' value='{$snippetToEdit->getTitle()}'/></p>
				<p>{_CODE}: </p>
				<textarea cols="80" rows="25" name="snipContent">{$snippetToEdit->getContent()}</textarea>
				<p><input type="submit" value="{_EDIT}" /></p>			
				</form>
		{/if}
	{/if}
{/block}