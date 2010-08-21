<h1>Letzte Seitenaufrufe</h1>
{include file='pageSelect.inc.tpl' pos=$vars.pos max=$vars.max linkClass='latestSites_pagelink'}


<table class=latestSites_hitTable>
    <col width="75">
    <col width="*">
    <col width="100">
    <col width="150">

	<tr>
		<th class=latestSites_record_time>Zeit</th>
		<th class=latestSites_record_url>URL</th>
		<th class=latestSites_record_origin>Rechner</th>
		<th class=latestSites_record_block>Sperren</th>
	</tr>
{assign var="current_date" value=""}
{assign var="current_domain" value=""}
{assign var="domain_block_no" value=1}
{foreach from=$vars.groups item=group}
	<tr class=latestSites_domain data-domainId="{$group[0].domainId}">
	<td colspan="1">&nbsp;</td>
	<td colspan="1" class=latestSites_domain><img src="icons/arrow_up.png" /><a target="_blank" href="http://{$group[0].domain}">{$group[0].domain}</a></td>
	<td colspan="2">&nbsp;</td>
	</tr>
	{foreach from=$group item=record}
	<tr class=latestSites_record style="display: none" data-domainId="{$record.domainId}">
		<td class=latestSites_record_time>{$record.time}</td>
		<td class=latestSites_record_url><img src="icons/world.png" /><a class=latestSites_urllink" target="_blank" href="{$record.url}">{$record.url|truncate:80}</a></td>
		<td class=latestSites_record_origin>{$record.origin}</td>
		<td class=latestSites_record_block>{$record.blockLinks}</td>
	</tr>
	{/foreach}
{/foreach}

</table>
{include file='pageSelect.inc.tpl' pos=$vars.pos max=$vars.max linkClass='latestSites_pagelink'}
{include file='footer.inc.tpl'}
