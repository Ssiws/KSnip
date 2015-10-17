{extends file='base.tpl'}
	{block name="title"}{_SETTINGS}{/block}
	{block name="maincontent"}
		<h1>{_SETTINGS} - KSnip v0.4</h1>
		<div class='bloc'>
			<h2>{_ENABLE_A_LANGUAGE}</h2>
			{if !empty(languages::getDisabledLanguages())}
				<form method="post">
				<input type="hidden" name="action" value="enableLanguages" />
				<select name="shortName" size="1">';
				{foreach languages::getDisabledLanguages() as $lang}
					<option value='{$lang->getLanguageId()}'>{$lang->getDisplayName(true)|escape}</option>
				{/foreach}
				</select>
				<p><input type="submit" value="{_ENABLE}" /></p>
				</form>
				{else}
					{_NO_MORE_LANGUAGES_TO_ENABLE}
			{/if}
			{if isset($resultat)}
				<p>{$resultat}</p>
			{/if}
		</div>
		
		<div class='bloc'>
			<h2>{_DISABLE_A_LANGUAGE}</h2>
			<form method="post">
				<input type="hidden" name="action" value="disableLanguages" />
				{foreach languages::getAvailableLanguages() as $lang}
					<p><input type='radio' name='grl' value='{$lang->getLanguageId()}' id='{$lang->getLanguageId()}'><label for='{$lang->getLanguageId()}'>{$lang->getDisplayName()}</label></p>
				{/foreach}
				<p><input type='submit' value='{_DISABLE_AND_DELETE_SNIPPETS}'/></p>
			</form>
		</div>	
		<div class='bloc'>
			<h2>{_REORG_MENU}</h2>
			<form method="POST">
				<input type="hidden" name="action" value="reorgLanguages" />
				{foreach languages::getAvailableLanguages() as $lang}
					<p><input type='submit' name='{$lang->getLanguageId()}-up' value='&#8593;'><input type='submit' name='{$lang->getLanguageId()}-dn' value='&#8595;'>{$lang->getDisplayName()}</p>
				{/foreach}
			</form>
		</div>
		<div class='bloc'>
			<h2>{_DL_EXT_TITLE}</h2>
			<p>{_DL_EXT}</p>
			<p>{_DL_EXT_DESCR}</p>
			<p>{_DL_EXT_DESCR_TOKEN}<pre>{$token}</pre></p>
		</div>
	{/block}