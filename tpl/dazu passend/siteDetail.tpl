<table class=siteDetail_hitTable>
    <col width="175">
    <col width="175">
    <col width="*">
    <col width="75">
    <col width="75">
    <col width="75">

	<tr>
		<th class=latestSites_record_time>Von</th>
		<th class=latestSites_record_time>Bis</th>
		<th class=latestSites_record_url>URL</th>
		<th class=latestSites_record_origin>Daten</th>
		<th class=latestSites_record_origin>Aufrufe</th>
		<th class=latestSites_record_block>Aktionen</th>
	</tr>

{foreach from=$vars.records item=record}
	<tr class=latestSites_record data-domain="{$record.domain}" data-block-no="{$domain_block_no}">
		<td class=latestSites_record_time>{$record.mintime}</td>
		<td class=latestSites_record_time>{$record.maxtime}</td>
		<td class=latestSites_record_url><img src="icons/world.png" /><a class=latestSites_urllink" target="_blank" href="{$record.url}">{$record.url|truncate:80}</a></td>
		<td class=latestSites_record_origin>{$record.size}</td>
		<td class=latestSites_record_origin>{$record.count}</td>
		<td class=latestSites_record_block>{$record.actions}</td>
	</tr>
{/foreach}
</table>
