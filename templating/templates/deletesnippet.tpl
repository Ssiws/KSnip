{extends file='base.tpl'}
	{block name="title"}{_DELETE_SNIPPET}{/block}
	{block name="maincontent"}
		<h1>{_DELETE_SNIPPET}</h1>
		<form method="post">
			<input type="hidden" name="confirm"/>
			{if isset($snippetToDelete)}
			{_DELETE} "{$snippetToDelete->getTitle()}" ?
				<p><input type='hidden' id='confirm'/></p>
				<input type='submit' value='{_DELETE_THIS_SNIPPET}'/>
			{/if}

		</form>
		
	{/block}
