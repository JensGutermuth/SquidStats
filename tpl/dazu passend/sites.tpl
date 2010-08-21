<h1>Seiten</h1>
{* filter mask *}

{* data *}
{include file='pageSelect.inc.tpl' pos=$vars.pos max=$vars.max linkClass='sites_pagelink'}

<table class=sites_domainTable>
<col width="100">
<col width="*">
	<tr>
		<th class=sites_record_size>Daten</th>
		<th class=sites_record_url>Domain</th>
	</tr>
{foreach from=$vars.records item=record}
	<tr class=sites_record data-domainId={$record.domainId}>
		<td class=sites_record_size>{$record.size}</td>
		<td class=sites_record_url><img src="icons/arrow_up.png" /><a href="http://{$record.domain}">{$record.domain}</a></td>
	</tr>
	<tr class=sites_detail id="site_{$record.domainId}_detail">
		<td colspan="2"></td>
	</tr>
{/foreach}
</table>
{include file='pageSelect.inc.tpl' pos=$vars.pos max=$vars.max linkClass='sites_pagelink'}
{include file='footer.inc.tpl'}
