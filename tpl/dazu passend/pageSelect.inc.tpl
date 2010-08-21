{*
	This is a snippet used to generate a page-selector. It requires the
	following variables to be set:
	$pos: The page shown at the moment
	$max: The higest pagenumber possible
	$linkClass: The class the links to the pages will have. They will have their
		 data-pos attribute set to the pagenumber for easy javascript access.
	
*}
<div class="pageSelect_container">
{if $pos > 6}
	{section name=i loop=3}
		<a class="{$linkClass}" data-pos="{$smarty.section.i.iteration}" href="javascript:void(0)">[{$smarty.section.i.iteration}]</a>
	{/section}
	 ... 

	{section name=i2 loop=7}
		{if $pos == $smarty.section.i2.iteration-4+$pos}
			[{$smarty.section.i2.iteration+$pos-4}]
		{else}
			<a class="{$linkClass}" data-pos="{$smarty.section.i2.iteration+$pos-4}" href="javascript:void(0)">[{$smarty.section.i2.iteration+$pos-4}]</a>
		{/if}
	{/section}
{else}
	{section name=i loop=10}
		{if $pos == $smarty.section.i.iteration}
			[{$smarty.section.i.iteration}]
		{else}
			<a class="{$linkClass}" data-pos="{$smarty.section.i.iteration}" href="javascript:void(0)">[{$smarty.section.i.iteration}]</a>
		{/if}
	{/section}
{/if}
 ... 

{section name=i3 loop=3}
	<a class="{$linkClass}" data-pos="{$smarty.section.i3.iteration+$max-3}" href="javascript:void(0)">[{$smarty.section.i3.iteration+$max-3}]</a>
{/section}
</div>
